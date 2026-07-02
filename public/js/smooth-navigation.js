(function () {
    if (window.__smoothNavigationLoaded) return;
    window.__smoothNavigationLoaded = true;

    // Inject page transition loader styles dynamically
    const style = document.createElement('style');
    style.textContent = `
        /* Page Transition Loader Bar */
        html.is-navigating::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #be123c, #fb7185, #be123c);
            background-size: 200% auto;
            z-index: 99999;
            animation: loadingBar 1.2s infinite linear, shimmer 2s infinite linear;
            transform-origin: 0% 50%;
        }
        @keyframes loadingBar {
            0% { transform: scaleX(0); }
            50% { transform: scaleX(0.7); }
            100% { transform: scaleX(1); }
        }
        @keyframes shimmer {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        html.is-navigating body {
            opacity: 0.7;
            filter: grayscale(10%) blur(0.2px);
            transition: opacity 0.3s ease, filter 0.3s ease;
        }
    `;
    document.head.appendChild(style);


    // ─────────────────────────────────────────────────────────────────────────
    // Detect the "CSS type" of a document's <head>:
    //   'tailwind' = uses <script src="cdn.tailwindcss.com">
    //   'inline'   = uses a large <style> block (admin/buyer dashboard)
    // ─────────────────────────────────────────────────────────────────────────
    function getCssType(headElement) {
        const scripts = headElement ? Array.from(headElement.querySelectorAll('script[src]')) : [];
        const hasTailwindCdn = scripts.some(s => (s.getAttribute('src') || '').includes('cdn.tailwindcss.com'));
        return hasTailwindCdn ? 'tailwind' : 'inline';
    }

    // CSS type of the page that was first fully loaded by the browser
    const currentCssType = getCssType(document.head);

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────
    const appState = { navigating: false };

    function isModifiedClick(event) {
        return event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;
    }

    function isSkippableLink(link) {
        if (!link.href || link.target || link.hasAttribute('download')) return true;
        const url = new URL(link.href, window.location.href);
        if (url.origin !== window.location.origin) return true;

        const path = url.pathname;
        const currentPath = window.location.pathname;

        // Skip auth routes, buyer dashboard, and admin panel to prevent layout style leakage & session/CSRF state bugs
        if (
            path === '/login' ||
            path === '/register' ||
            path === '/logout' ||
            path === '/dashboard' ||
            path.startsWith('/admin') ||
            currentPath === '/login' ||
            currentPath === '/register' ||
            currentPath === '/dashboard' ||
            currentPath.startsWith('/admin')
        ) {
            return true;
        }

        return url.pathname === window.location.pathname &&
               url.search  === window.location.search  &&
               url.hash;
    }

    function showLoading() { document.documentElement.classList.add('is-navigating'); }
    function hideLoading()  { document.documentElement.classList.remove('is-navigating'); }

    // ─────────────────────────────────────────────────────────────────────────
    // Re-execute all <script> tags inside a container so dynamic JS runs
    // ─────────────────────────────────────────────────────────────────────────
    function runScripts(container) {
        container.querySelectorAll('script').forEach((oldScript) => {
            const newScript = document.createElement('script');
            Array.from(oldScript.attributes).forEach((attr) => {
                newScript.setAttribute(attr.name, attr.value);
            });
            newScript.textContent = oldScript.textContent;
            oldScript.replaceWith(newScript);
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Sync <head> assets between pages of the SAME css type.
    // Uses smart diffing so existing assets are never double-loaded.
    // ─────────────────────────────────────────────────────────────────────────
    function syncHeadAssets(nextDocument) {
        const currentEls = Array.from(document.head.children);
        const nextEls    = Array.from(nextDocument.head.children);

        function matches(a, b) {
            if (a.tagName !== b.tagName) return false;
            const tag = a.tagName.toLowerCase();
            if (tag === 'link') {
                return a.getAttribute('href') === b.getAttribute('href') &&
                       a.getAttribute('rel')  === b.getAttribute('rel');
            }
            if (tag === 'script') {
                const sa = a.getAttribute('src'), sb = b.getAttribute('src');
                return (sa || sb) ? sa === sb : a.textContent.trim() === b.textContent.trim();
            }
            if (tag === 'style') {
                if (a.id && b.id) return a.id === b.id;
                return a.textContent.trim() === b.textContent.trim();
            }
            if (tag === 'meta') {
                return a.getAttribute('name')       === b.getAttribute('name')       &&
                       a.getAttribute('content')    === b.getAttribute('content')    &&
                       a.getAttribute('charset')    === b.getAttribute('charset')    &&
                       a.getAttribute('http-equiv') === b.getAttribute('http-equiv');
            }
            return false;
        }

        // Remove dynamic assets no longer needed
        currentEls.forEach((el) => {
            if (el.dataset.smoothHead !== 'true') return;
            if (!nextEls.some(n => matches(el, n))) el.remove();
        });

        // Add new assets from the next page
        nextEls.forEach((nextEl) => {
            if (nextEl.tagName.toLowerCase() === 'title') return;

            if (currentEls.some(c => matches(c, nextEl))) return; // already present

            let clone;
            if (nextEl.tagName.toLowerCase() === 'script') {
                // Must create a fresh script element — cloneNode won't execute it
                clone = document.createElement('script');
                Array.from(nextEl.attributes).forEach(attr => clone.setAttribute(attr.name, attr.value));
                clone.textContent = nextEl.textContent;
            } else {
                clone = nextEl.cloneNode(true);
            }
            clone.dataset.smoothHead = 'true';
            document.head.appendChild(clone);
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Replace page content via AJAX (only for same-CSS-type pages)
    // ─────────────────────────────────────────────────────────────────────────
    function replacePage(html, url, shouldPushState) {
        const parser       = new DOMParser();
        const nextDocument = parser.parseFromString(html, 'text/html');

        if (!nextDocument.body) {
            window.location.href = url;
            return;
        }

        document.title = nextDocument.title || document.title;
        syncHeadAssets(nextDocument);
        document.body.className = nextDocument.body.className;
        document.body.innerHTML = nextDocument.body.innerHTML;

        // Keep CSRF token fresh
        const nextCsrf    = nextDocument.querySelector('meta[name="csrf-token"]')?.content;
        const currentCsrf = document.querySelector('meta[name="csrf-token"]');
        if (nextCsrf && currentCsrf) currentCsrf.setAttribute('content', nextCsrf);

        runScripts(document.body);

        if (window.Alpine?.initTree) {
            window.Alpine.initTree(document.body);
        }

        if (shouldPushState) {
            window.history.pushState({}, '', url);
        }

        window.scrollTo({ top: 0, behavior: 'instant' });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Fetch a URL, decide whether to do AJAX swap or full-page navigation.
    //
    // KEY RULE: If the target page uses a DIFFERENT CSS approach than the
    // current page (e.g. current=inline-CSS, target=Tailwind CDN), we MUST
    // do a full browser navigation. Tailwind Play CDN can only scan the DOM
    // once at load time; swapping body.innerHTML won't re-trigger it.
    // ─────────────────────────────────────────────────────────────────────────
    async function loadPage(url, options = {}) {
        if (appState.navigating) return;

        appState.navigating = true;
        showLoading();

        try {
            const headers = {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html, application/xhtml+xml',
                ...(options.headers || {}),
            };

            const response = await fetch(url, {
                ...options,
                headers,
                credentials: 'same-origin',
            });

            const contentType = response.headers.get('content-type') || '';
            if (!contentType.includes('text/html')) {
                window.location.href = response.url || url;
                return;
            }

            const html          = await response.text();
            const parser        = new DOMParser();
            const nextDoc       = parser.parseFromString(html, 'text/html');
            const targetCssType = getCssType(nextDoc.head);

            // ── CSS frameworks differ → full page navigation ──────────────────
            if (targetCssType !== currentCssType) {
                window.location.href = response.url || url;
                return;
            }

            // ── Same CSS framework → safe to do AJAX swap ─────────────────────
            replacePage(html, response.url || url, options.pushState !== false);

        } catch (error) {
            window.location.href = url;
        } finally {
            appState.navigating = false;
            hideLoading();
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Event listeners
    // ─────────────────────────────────────────────────────────────────────────
    document.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link || isModifiedClick(event) || isSkippableLink(link)) return;

        event.preventDefault();
        loadPage(link.href);
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || form.dataset.noAjax === 'true') return;

        const actionAttr = form.getAttribute('action') || '';
        let actionPath = '';
        try {
            actionPath = new URL(actionAttr, window.location.href).pathname;
        } catch (e) {
            actionPath = actionAttr;
        }

        const currentPath = window.location.pathname;

        // Skip auth routes, buyer dashboard, and admin panel form submissions to ensure clean session transitions
        if (
            actionPath === '/login' ||
            actionPath === '/register' ||
            actionPath === '/logout' ||
            actionPath.startsWith('/admin') ||
            currentPath === '/login' ||
            currentPath === '/register' ||
            currentPath === '/dashboard' ||
            currentPath.startsWith('/admin')
        ) {
            return; // Let standard form submission handle it
        }

        event.preventDefault();

        const method   = (form.getAttribute('method') || 'GET').toUpperCase();
        const action   = form.getAttribute('action') || window.location.href;
        const formData = new FormData(form);
        const submitter = event.submitter;

        if (submitter?.name) {
            formData.append(submitter.name, submitter.value);
        }

        if (method === 'GET') {
            const url = new URL(action, window.location.href);
            url.search = new URLSearchParams(formData).toString();
            loadPage(url.toString());
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        loadPage(action, {
            method,
            body: formData,
            headers: csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {},
        });
    });

    window.addEventListener('popstate', () => {
        // On back/forward, always do a full reload to avoid CSS mismatch issues
        window.location.reload();
    });
})();
