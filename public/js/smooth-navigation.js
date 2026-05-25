(function () {
    if (window.__smoothNavigationLoaded) return;
    window.__smoothNavigationLoaded = true;

    const appState = {
        navigating: false,
    };

    function isModifiedClick(event) {
        return event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;
    }

    function isSkippableLink(link) {
        if (!link.href || link.target || link.hasAttribute('download')) return true;

        const url = new URL(link.href, window.location.href);
        if (url.origin !== window.location.origin) return true;

        return url.pathname === window.location.pathname
            && url.search === window.location.search
            && url.hash;
    }

    function showLoading() {
        document.documentElement.classList.add('is-navigating');
    }

    function hideLoading() {
        document.documentElement.classList.remove('is-navigating');
    }

    function runScripts(container) {
        container.querySelectorAll('script').forEach((oldScript) => {
            const newScript = document.createElement('script');

            Array.from(oldScript.attributes).forEach((attribute) => {
                newScript.setAttribute(attribute.name, attribute.value);
            });

            newScript.textContent = oldScript.textContent;
            oldScript.replaceWith(newScript);
        });
    }

    function replacePage(html, url, shouldPushState) {
        const parser = new DOMParser();
        const nextDocument = parser.parseFromString(html, 'text/html');

        if (!nextDocument.body) {
            window.location.href = url;
            return;
        }

        document.title = nextDocument.title || document.title;
        document.body.className = nextDocument.body.className;
        document.body.innerHTML = nextDocument.body.innerHTML;

        const csrfToken = nextDocument.querySelector('meta[name="csrf-token"]')?.content;
        const currentToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken && currentToken) currentToken.setAttribute('content', csrfToken);

        runScripts(document.body);
        if (window.Alpine?.initTree) {
            window.Alpine.initTree(document.body);
        }

        if (shouldPushState) {
            window.history.pushState({}, '', url);
        }

        window.scrollTo({ top: 0, behavior: 'instant' });
    }

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

            const html = await response.text();
            replacePage(html, response.url || url, options.pushState !== false);
        } catch (error) {
            window.location.href = url;
        } finally {
            appState.navigating = false;
            hideLoading();
        }
    }

    document.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (!link || isModifiedClick(event) || isSkippableLink(link)) return;

        event.preventDefault();
        loadPage(link.href);
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || form.dataset.noAjax === 'true') return;

        event.preventDefault();

        const method = (form.getAttribute('method') || 'GET').toUpperCase();
        const action = form.getAttribute('action') || window.location.href;
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
        loadPage(window.location.href, { pushState: false });
    });
})();
