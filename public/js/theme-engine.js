/**
 * PASHMOOD Theme Engine v2.1
 * Works on ALL pages — Tailwind CDN and custom-CSS alike.
 * Uses MutationObserver to guarantee our style is ALWAYS last in head.
 */
(function (global) {
    'use strict';

    if (global.ThemeEngine) return;

    /* ══════════════════════════════════════════════
       PRESETS
    ══════════════════════════════════════════════ */
    var PRESETS = {
        light: {
            'Default Light': { bg: '#EEEEEE', fg: '#1a1a2e', accent: '#e11d48' },
            'Ocean Light':   { bg: '#E8F4FD', fg: '#0a2540', accent: '#007ACC' },
            'Forest Light':  { bg: '#EDF7ED', fg: '#1a3a1a', accent: '#1E5309' },
            'Rose Light':    { bg: '#FDF0F3', fg: '#2a1a1e', accent: '#e11d48' },
            'Sand Light':    { bg: '#F5F0E8', fg: '#2a2010', accent: '#d97706' }
        },
        dark: {
            'Default Dark':  { bg: '#101010', fg: '#FBFBFB', accent: '#e11d48' },
            'Midnight':      { bg: '#0D1117', fg: '#E6EDF3', accent: '#58a6ff' },
            'Dracula':       { bg: '#282A36', fg: '#F8F8F2', accent: '#BD93F9' },
            'Emerald Dark':  { bg: '#0D1F1A', fg: '#E0FBF1', accent: '#2CCC00' },
            'Mocha':         { bg: '#1E1B18', fg: '#F4EDE4', accent: '#d97706' }
        }
    };

    var DEFAULTS = {
        mode:  'light',
        light: { bg: '#EEEEEE', fg: '#1a1a2e', accent: '#e11d48' },
        dark:  { bg: '#101010', fg: '#FBFBFB', accent: '#e11d48' }
    };

    var LS_KEY = 'pashmood_theme_v2';

    /* ══════════════════════════════════════════════
       STORAGE
    ══════════════════════════════════════════════ */
    function load() {
        try {
            var raw = localStorage.getItem(LS_KEY);
            if (raw) return deepMerge(JSON.parse(JSON.stringify(DEFAULTS)), JSON.parse(raw));
        } catch (e) {}
        return JSON.parse(JSON.stringify(DEFAULTS));
    }

    function save(settings) {
        try { localStorage.setItem(LS_KEY, JSON.stringify(settings)); } catch (e) {}
    }

    /* ══════════════════════════════════════════════
       MODE RESOLVER
    ══════════════════════════════════════════════ */
    function resolveMode(mode) {
        if (mode === 'system') {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }
        return mode === 'dark' ? 'dark' : 'light';
    }

    /* ══════════════════════════════════════════════
       COLOR HELPERS
    ══════════════════════════════════════════════ */
    function hexToRgb(hex) {
        hex = hex.replace(/^#/, '');
        return {
            r: parseInt(hex.slice(0, 2), 16),
            g: parseInt(hex.slice(2, 4), 16),
            b: parseInt(hex.slice(4, 6), 16)
        };
    }

    function rgbToHex(r, g, b) {
        return '#' + [r, g, b].map(function(v) { return ('0' + Math.max(0, Math.min(255, Math.round(v))).toString(16)).slice(-2); }).join('');
    }

    function lighten(hex, pct) {
        var c = hexToRgb(hex), f = pct / 100;
        return rgbToHex(c.r + (255 - c.r) * f, c.g + (255 - c.g) * f, c.b + (255 - c.b) * f);
    }

    function darken(hex, pct) {
        var c = hexToRgb(hex), f = pct / 100;
        return rgbToHex(c.r * (1 - f), c.g * (1 - f), c.b * (1 - f));
    }

    function rgba(hex, alpha) {
        var c = hexToRgb(hex);
        return 'rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + alpha + ')';
    }

    /* ══════════════════════════════════════════════
       BUILD STYLE CONTENT
    ══════════════════════════════════════════════ */
    function buildCSS(settings) {
        var mode   = resolveMode(settings.mode);
        var p      = settings[mode];
        var bg     = p.bg, fg = p.fg, accent = p.accent;

        var cardBg    = mode === 'dark' ? lighten(bg, 8)  : '#ffffff';
        var surface   = mode === 'dark' ? lighten(bg, 8)  : darken(bg, 3);
        var surface2  = mode === 'dark' ? lighten(bg, 14) : darken(bg, 7);
        var border    = mode === 'dark' ? lighten(bg, 18) : darken(bg, 10);
        var sidebarBg = mode === 'dark' ? lighten(bg, 5)  : '#ffffff';
        var navBg     = mode === 'dark' ? rgba(lighten(bg, 6), 0.92) : 'rgba(255,255,255,0.85)';

        var vars = {
            '--theme-bg':           bg,
            '--theme-fg':           fg,
            '--theme-accent':       accent,
            '--theme-accent-light': lighten(accent, 25),
            '--theme-accent-pale':  lighten(accent, 70),
            '--theme-accent-dark':  darken(accent, 15),
            '--theme-accent-alpha': rgba(accent, 0.15),
            '--theme-surface':      surface,
            '--theme-surface-2':    surface2,
            '--theme-border':       border,
            '--theme-fg-muted':     rgba(fg, 0.55),
            '--theme-fg-subtle':    rgba(fg, 0.35),
            '--primary':            accent,
            '--primary-dark':       darken(accent, 12),
            '--primary-light':      lighten(accent, 15),
            '--primary-pale':       lighten(accent, 70),
            '--body-bg':            bg,
            '--card-bg':            cardBg,
            '--text':               fg,
            '--muted':              rgba(fg, 0.5),
            '--border':             border,
            '--sidebar-bg':         sidebarBg
        };

        var cssVars = ':root{' + Object.keys(vars).map(function(k){ return k+':'+vars[k]; }).join(';') + '}';

        var overrides = '';
        if (mode === 'dark') {
            overrides = [
                /* ── Base ── */
                'html[data-theme="dark"]{background:'+bg+'!important;color:'+fg+'!important;color-scheme:dark}',
                '[data-theme="dark"] body{background:'+bg+'!important;color:'+fg+'!important}',

                /* ── Navigation — fully opaque dark so glass blur doesn't bleed-through pink section ── */
                '[data-theme="dark"] nav{background:'+lighten(bg,5)+'!important;border-color:'+border+'!important;backdrop-filter:none!important;-webkit-backdrop-filter:none!important}',
                '[data-theme="dark"] .glass-morphism{background:'+lighten(bg,5)+'!important;border-color:'+border+'!important;backdrop-filter:none!important;-webkit-backdrop-filter:none!important}',
                '[data-theme="dark"] nav a,[data-theme="dark"] nav button,[data-theme="dark"] nav span,[data-theme="dark"] nav h1{color:'+fg+'!important}',
                '[data-theme="dark"] nav svg,[data-theme="dark"] .glass-morphism svg{color:'+rgba(fg,0.75)+'!important;stroke:'+rgba(fg,0.75)+'}',

                /* ── Hero section (clears gradient background-image) ── */
                '[data-theme="dark"] section{background:'+bg+'!important}',

                /* ── White surfaces → dark card background ── */
                '[data-theme="dark"] .bg-white{background:'+cardBg+'!important;color:'+fg+'!important}',

                /* ── Product image container backgrounds ── */
                '[data-theme="dark"] .bg-rose-50,[data-theme="dark"] .bg-rose-100{background:'+lighten(bg,10)+'!important}',
                '[data-theme="dark"] .bg-slate-50,[data-theme="dark"] .bg-slate-100,[data-theme="dark"] .bg-slate-200{background:'+lighten(bg,8)+'!important}',
                '[data-theme="dark"] .bg-gray-50{background:'+lighten(bg,4)+'!important}',
                '[data-theme="dark"] .bg-gray-100{background:'+lighten(bg,7)+'!important}',
                '[data-theme="dark"] .bg-gray-200{background:'+lighten(bg,12)+'!important}',

                /* ── Text colors ── */
                '[data-theme="dark"] .text-slate-900,[data-theme="dark"] .text-slate-800,[data-theme="dark"] .text-slate-700,[data-theme="dark"] .text-gray-900,[data-theme="dark"] .text-gray-800,[data-theme="dark"] .text-gray-700{color:'+fg+'!important}',
                '[data-theme="dark"] .text-slate-600,[data-theme="dark"] .text-slate-500,[data-theme="dark"] .text-gray-600,[data-theme="dark"] .text-gray-500{color:'+rgba(fg,0.65)+'!important}',
                '[data-theme="dark"] .text-slate-400,[data-theme="dark"] .text-slate-300,[data-theme="dark"] .text-gray-400{color:'+rgba(fg,0.45)+'!important}',

                /* ── Borders ── */
                '[data-theme="dark"] .border-gray-200,[data-theme="dark"] .border-gray-100,[data-theme="dark"] .border-slate-200,[data-theme="dark"] .border-slate-100,[data-theme="dark"] .border-rose-100{border-color:'+border+'!important}',

                /* ── Inputs ── */
                '[data-theme="dark"] input:not([type=submit]):not([type=button]):not([type=range]):not([type=color]),[data-theme="dark"] textarea,[data-theme="dark"] select{background:'+lighten(bg,10)+'!important;color:'+fg+'!important;border-color:'+border+'!important}',

                /* ── Product card: add subtle border so dark card stands out from dark bg ── */
                '[data-theme="dark"] .hover-lift{border:1px solid '+border+'}',

                /* ── Shadows ── */
                '[data-theme="dark"] .shadow,[data-theme="dark"] .shadow-md,[data-theme="dark"] .shadow-lg,[data-theme="dark"] .shadow-xl{box-shadow:0 2px 20px rgba(0,0,0,0.6)!important}',

                /* ── Footer / dividers ── */
                '[data-theme="dark"] footer{background:'+darken(bg,5)+'!important;color:'+fg+'!important}',
                '[data-theme="dark"] hr{border-color:'+border+'!important}',

                /* ── Active nav/button bg (slate-900 used as button bg) ── */
                '[data-theme="dark"] .bg-slate-900{background:'+lighten(bg,20)+'!important;color:'+fg+'!important}'
            ].join('');
        } else {
            overrides = [
                'html[data-theme="light"]{background:'+bg+';color:'+fg+';color-scheme:light}',
                '[data-theme="light"] body{background:'+bg+';color:'+fg+'}'
            ].join('');
        }


        return cssVars + overrides;
    }

    /* ══════════════════════════════════════════════
       APPLY TO DOM
    ══════════════════════════════════════════════ */
    function applyToDom(settings) {
        var mode = resolveMode(settings.mode);
        var p    = settings[mode];
        var bg   = p.bg, fg = p.fg, accent = p.accent;

        var cardBg    = mode === 'dark' ? lighten(bg, 8)  : '#ffffff';
        var surface   = mode === 'dark' ? lighten(bg, 8)  : darken(bg, 3);
        var surface2  = mode === 'dark' ? lighten(bg, 14) : darken(bg, 7);
        var border    = mode === 'dark' ? lighten(bg, 18) : darken(bg, 10);
        var sidebarBg = mode === 'dark' ? lighten(bg, 5)  : '#ffffff';

        // ── 1. data-theme attribute ──
        document.documentElement.setAttribute('data-theme', mode);

        // ── 2. Inline style on <html> (highest specificity) ──
        var root = document.documentElement;
        var inlineVars = {
            '--theme-bg': bg, '--theme-fg': fg, '--theme-accent': accent,
            '--theme-accent-light': lighten(accent,25), '--theme-accent-pale': lighten(accent,70),
            '--theme-accent-dark': darken(accent,15), '--theme-accent-alpha': rgba(accent,0.15),
            '--theme-surface': surface, '--theme-surface-2': surface2, '--theme-border': border,
            '--theme-fg-muted': rgba(fg,0.55), '--theme-fg-subtle': rgba(fg,0.35),
            '--primary': accent, '--primary-dark': darken(accent,12),
            '--primary-light': lighten(accent,15), '--primary-pale': lighten(accent,70),
            '--body-bg': bg, '--card-bg': cardBg, '--text': fg,
            '--muted': rgba(fg,0.5), '--border': border, '--sidebar-bg': sidebarBg
        };
        Object.keys(inlineVars).forEach(function(k) { root.style.setProperty(k, inlineVars[k]); });

        // ── 3. Inject / update <style> tag ──
        var el = document.getElementById('pashmood-theme-vars');
        if (!el) {
            el = document.createElement('style');
            el.id = 'pashmood-theme-vars';
        }
        el.textContent = buildCSS(settings);
        // Always append to end of head (moves if already there)
        document.head.appendChild(el);
    }

    /* ══════════════════════════════════════════════
       MUTATION OBSERVER — keep our style LAST in head
       so it always wins after Tailwind CDN adds its style
    ══════════════════════════════════════════════ */
    function startObserver() {
        if (!window.MutationObserver) return;
        var observer = new MutationObserver(function() {
            var el = document.getElementById('pashmood-theme-vars');
            if (el && el !== document.head.lastElementChild) {
                document.head.appendChild(el);
            }
        });
        observer.observe(document.head, { childList: true });
    }

    /* ══════════════════════════════════════════════
       DEEP MERGE
    ══════════════════════════════════════════════ */
    function deepMerge(target, source) {
        var result = Object.assign({}, target);
        Object.keys(source || {}).forEach(function(key) {
            if (source[key] && typeof source[key] === 'object' && !Array.isArray(source[key])) {
                result[key] = deepMerge(target[key] || {}, source[key]);
            } else {
                result[key] = source[key];
            }
        });
        return result;
    }

    /* ══════════════════════════════════════════════
       PUBLIC API
    ══════════════════════════════════════════════ */
    var ThemeEngine = {
        presets: PRESETS,
        get: function() { return load(); },
        preview: function(s) { applyToDom(s); },
        apply: function(s) {
            var m = deepMerge(JSON.parse(JSON.stringify(DEFAULTS)), s);
            save(m); applyToDom(m); return m;
        },
        set: function(patch) {
            var m = deepMerge(load(), patch);
            save(m); applyToDom(m); return m;
        },
        toggle: function() {
            var c = load(), next = c.mode === 'dark' ? 'light' : 'dark';
            return ThemeEngine.set({ mode: next });
        },
        reset: function() { return ThemeEngine.apply(JSON.parse(JSON.stringify(DEFAULTS))); },
        activeMode: function() { return resolveMode(load().mode); },
        helpers: { lighten: lighten, darken: darken, rgba: rgba, hexToRgb: hexToRgb }
    };

    /* ══════════════════════════════════════════════
       INIT
    ══════════════════════════════════════════════ */
    (function init() {
        applyToDom(load());

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                applyToDom(load());
                startObserver();
            });
        } else {
            startObserver();
        }

        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
                var c = load(); if (c.mode === 'system') applyToDom(c);
            });
        }
    })();

    global.ThemeEngine = ThemeEngine;

})(window);
