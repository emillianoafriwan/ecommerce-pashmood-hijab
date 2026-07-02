{{-- ══════════════════════════════════════════════════════
     SIDEBAR THEME PANEL — Full Light/Dark Editor
     Requires: /js/theme-engine.js loaded in <head>
══════════════════════════════════════════════════════ --}}

@php
    $savedSettings = null;
    if (auth()->check() && auth()->user()->theme_settings) {
        $savedSettings = auth()->user()->theme_settings;
    }
    $csrfToken   = csrf_token();
    $settingsUrl = route('profile.theme.settings');
    $isLoggedIn  = auth()->check();
@endphp

<div id="theme-panel-wrap" style="margin:8px 14px 4px;">

    {{-- ── Toggle Button ── --}}
    <button type="button" id="theme-panel-toggle" onclick="tpToggle()"
        style="display:flex;align-items:center;justify-content:space-between;width:100%;padding:10px 12px;background:var(--body-bg,#f5f7fb);border:1px solid var(--border,#e8eaf0);border-radius:10px;cursor:pointer;gap:8px;transition:background .2s;">
        <div style="display:flex;align-items:center;gap:9px;font-size:13px;font-weight:600;color:var(--text,#1a1a2e);">
            <span id="tp-mode-icon">🎨</span>
            <span>Tema Warna</span>
        </div>
        <svg id="tp-chevron" width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             style="flex-shrink:0;transition:transform .25s;color:var(--muted,#4a4a6a);">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- ── Panel Body ── --}}
    <div id="theme-panel-body" style="display:none;border:1px solid var(--border,#e8eaf0);border-top:none;border-radius:0 0 10px 10px;background:var(--card-bg,#fff);overflow:hidden;">

        {{-- Mode Toggle --}}
        <div style="padding:12px 14px 8px;border-bottom:1px solid var(--border,#e8eaf0);">
            <div style="font-size:10px;font-weight:700;color:var(--muted,#4a4a6a);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Mode</div>
            <div style="display:flex;gap:4px;">
                <button type="button" onclick="tpSetMode('light')"  id="tp-btn-light" class="tp-mode-btn">☀️ Light</button>
                <button type="button" onclick="tpSetMode('dark')"   id="tp-btn-dark"  class="tp-mode-btn">🌙 Dark</button>
                <button type="button" onclick="tpSetMode('system')" id="tp-btn-system" class="tp-mode-btn">🖥️ Auto</button>
            </div>
        </div>

        {{-- Light Theme Section --}}
        <div style="padding:12px 14px;" id="tp-light-section">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:12px;font-weight:700;color:var(--text,#1a1a2e);">Light Theme</span>
                <div style="display:flex;align-items:center;gap:6px;">
                    <button type="button" onclick="tpResetLight()" title="Reset" style="background:none;border:none;cursor:pointer;color:var(--muted,#4a4a6a);font-size:14px;padding:2px;">↺</button>
                    <select id="tp-light-preset" onchange="tpApplyLightPreset(this.value)"
                        style="font-size:11px;font-weight:600;color:var(--text,#1a1a2e);background:var(--body-bg,#f5f7fb);border:1px solid var(--border,#e8eaf0);border-radius:6px;padding:3px 6px;cursor:pointer;outline:none;">
                        <option value="">Preset</option>
                        <option value="Default Light">Default Light</option>
                        <option value="Ocean Light">Ocean Light</option>
                        <option value="Forest Light">Forest Light</option>
                        <option value="Rose Light">Rose Light</option>
                        <option value="Sand Light">Sand Light</option>
                    </select>
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Background</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-light-bg-swatch" onclick="document.getElementById('tp-light-bg-pick').click()" style="background:#EEEEEE;"></div>
                    <input type="color" id="tp-light-bg-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('light','bg',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-light-bg-hex" class="tp-hex" value="EEEEEE" maxlength="6"
                           onblur="tpOnHexBlur('light','bg',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('light','bg',this.value)">
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Foreground</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-light-fg-swatch" onclick="document.getElementById('tp-light-fg-pick').click()" style="background:#1a1a2e;"></div>
                    <input type="color" id="tp-light-fg-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('light','fg',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-light-fg-hex" class="tp-hex" value="1a1a2e" maxlength="6"
                           onblur="tpOnHexBlur('light','fg',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('light','fg',this.value)">
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Accent</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-light-accent-swatch" onclick="document.getElementById('tp-light-accent-pick').click()" style="background:#e11d48;"></div>
                    <input type="color" id="tp-light-accent-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('light','accent',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-light-accent-hex" class="tp-hex" value="e11d48" maxlength="6"
                           onblur="tpOnHexBlur('light','accent',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('light','accent',this.value)">
                </div>
            </div>
        </div>

        <div style="height:1px;background:var(--border,#e8eaf0);margin:0 14px;"></div>

        {{-- Dark Theme Section --}}
        <div style="padding:12px 14px;" id="tp-dark-section">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <span style="font-size:12px;font-weight:700;color:var(--text,#1a1a2e);">Dark Theme</span>
                <div style="display:flex;align-items:center;gap:6px;">
                    <button type="button" onclick="tpResetDark()" title="Reset" style="background:none;border:none;cursor:pointer;color:var(--muted,#4a4a6a);font-size:14px;padding:2px;">↺</button>
                    <select id="tp-dark-preset" onchange="tpApplyDarkPreset(this.value)"
                        style="font-size:11px;font-weight:600;color:var(--text,#1a1a2e);background:var(--body-bg,#f5f7fb);border:1px solid var(--border,#e8eaf0);border-radius:6px;padding:3px 6px;cursor:pointer;outline:none;">
                        <option value="">Preset</option>
                        <option value="Default Dark">Default Dark</option>
                        <option value="Midnight">Midnight</option>
                        <option value="Dracula">Dracula</option>
                        <option value="Emerald Dark">Emerald Dark</option>
                        <option value="Mocha">Mocha</option>
                    </select>
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Background</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-dark-bg-swatch" onclick="document.getElementById('tp-dark-bg-pick').click()" style="background:#101010;"></div>
                    <input type="color" id="tp-dark-bg-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('dark','bg',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-dark-bg-hex" class="tp-hex" value="101010" maxlength="6"
                           onblur="tpOnHexBlur('dark','bg',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('dark','bg',this.value)">
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Foreground</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-dark-fg-swatch" onclick="document.getElementById('tp-dark-fg-pick').click()" style="background:#FBFBFB;"></div>
                    <input type="color" id="tp-dark-fg-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('dark','fg',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-dark-fg-hex" class="tp-hex" value="FBFBFB" maxlength="6"
                           onblur="tpOnHexBlur('dark','fg',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('dark','fg',this.value)">
                </div>
            </div>
            <div class="tp-color-row">
                <span class="tp-label">Accent</span>
                <div class="tp-color-right">
                    <div class="tp-swatch" id="tp-dark-accent-swatch" onclick="document.getElementById('tp-dark-accent-pick').click()" style="background:#e11d48;"></div>
                    <input type="color" id="tp-dark-accent-pick" style="position:absolute;opacity:0;width:1px;height:1px;" oninput="tpOnColorInput('dark','accent',this.value)" onchange="tpSave()">
                    <span class="tp-hash">#</span>
                    <input type="text" id="tp-dark-accent-hex" class="tp-hex" value="e11d48" maxlength="6"
                           onblur="tpOnHexBlur('dark','accent',this.value)" onkeydown="if(event.key==='Enter')tpOnHexBlur('dark','accent',this.value)">
                </div>
            </div>
        </div>

        {{-- Save Indicator --}}
        <div id="tp-save-indicator" style="display:none;padding:6px 14px 10px;text-align:center;font-size:11px;font-weight:600;color:#059669;">
            ✓ Tersimpan
        </div>

    </div>
</div>

<style>
.tp-mode-btn {
    flex: 1;
    padding: 5px 4px;
    font-size: 10px;
    font-weight: 600;
    border: 1px solid var(--border, #e8eaf0);
    border-radius: 7px;
    background: var(--body-bg, #f5f7fb);
    color: var(--muted, #4a4a6a);
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.tp-mode-btn.active {
    background: var(--primary, #e11d48);
    color: #fff;
    border-color: var(--primary, #e11d48);
}
.tp-color-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 0;
    border-bottom: 1px solid var(--border, #e8eaf0);
}
.tp-color-row:last-child { border-bottom: none; }
.tp-label {
    font-size: 12px;
    font-weight: 500;
    color: var(--muted, #4a4a6a);
}
.tp-color-right {
    display: flex;
    align-items: center;
    gap: 5px;
    position: relative;
}
.tp-swatch {
    width: 22px;
    height: 22px;
    border-radius: 5px;
    border: 1.5px solid var(--border, #e8eaf0);
    cursor: pointer;
    flex-shrink: 0;
    transition: transform .15s;
}
.tp-swatch:hover { transform: scale(1.1); }
.tp-hash {
    font-size: 11px;
    font-weight: 700;
    color: var(--muted, #4a4a6a);
}
.tp-hex {
    width: 64px;
    font-size: 11px;
    font-weight: 700;
    color: var(--text, #1a1a2e);
    background: var(--body-bg, #f5f7fb);
    border: 1px solid var(--border, #e8eaf0);
    border-radius: 6px;
    padding: 3px 6px;
    outline: none;
    text-transform: uppercase;
    font-family: monospace;
}
.tp-hex:focus { border-color: var(--primary, #e11d48); }
</style>

<script>
(function () {
    /* Wait for ThemeEngine to be available */
    function ready(fn) {
        if (window.ThemeEngine) { fn(); }
        else { document.addEventListener('DOMContentLoaded', fn); }
    }

    ready(function () {
        const isLoggedIn  = @json($isLoggedIn);
        const settingsUrl = @json($settingsUrl);
        const csrfToken   = @json($csrfToken);
        const serverSaved = @json($savedSettings);

        /* ── Init from server settings or localStorage ── */
        let settings = ThemeEngine.get();
        if (serverSaved && serverSaved.light && serverSaved.dark) {
            settings = ThemeEngine.apply(serverSaved);
        }

        syncAllUI(settings);

        /* ════════════ Panel toggle ════════════ */
        window.tpToggle = function () {
            const body   = document.getElementById('theme-panel-body');
            const chev   = document.getElementById('tp-chevron');
            const toggle = document.getElementById('theme-panel-toggle');
            if (!body) return;
            const open = body.style.display !== 'none';
            body.style.display = open ? 'none' : 'block';
            if (chev)   chev.style.transform   = open ? '' : 'rotate(180deg)';
            if (toggle) toggle.style.borderRadius = open ? '10px' : '10px 10px 0 0';
        };

        /* ════════════ Mode ════════════ */
        window.tpSetMode = function (mode) {
            settings = ThemeEngine.set({ mode });
            syncModeButtons(mode);
            tpSave();
        };

        /* ════════════ Preset apply ════════════ */
        window.tpApplyLightPreset = function (name) {
            if (!name || !ThemeEngine.presets.light[name]) return;
            const p = ThemeEngine.presets.light[name];
            settings = ThemeEngine.set({ light: p });
            syncSectionUI('light', p);
            tpSave();
        };

        window.tpApplyDarkPreset = function (name) {
            if (!name || !ThemeEngine.presets.dark[name]) return;
            const p = ThemeEngine.presets.dark[name];
            settings = ThemeEngine.set({ dark: p });
            syncSectionUI('dark', p);
            tpSave();
        };

        /* ════════════ Reset ════════════ */
        window.tpResetLight = function () {
            tpApplyLightPreset('Default Light');
            document.getElementById('tp-light-preset').value = 'Default Light';
        };

        window.tpResetDark = function () {
            tpApplyDarkPreset('Default Dark');
            document.getElementById('tp-dark-preset').value = 'Default Dark';
        };

        /* ════════════ Color input handlers ════════════ */
        window.tpOnColorInput = function (section, key, hex) {
            const patch = {};
            patch[section] = {};
            patch[section][key] = hex;
            settings = ThemeEngine.set(patch);
            syncColorUI(section, key, hex);
        };

        window.tpOnHexBlur = function (section, key, val) {
            val = val.replace('#', '');
            if (/^[0-9A-F]{6}$/i.test(val)) {
                const hex = '#' + val;
                tpOnColorInput(section, key, hex);
                tpSave();
            } else {
                // Restore from current settings
                const current = ThemeEngine.get();
                const hexVal  = current[section] && current[section][key]
                    ? current[section][key].replace('#', '') : 'e11d48';
                document.getElementById('tp-' + section + '-' + key + '-hex').value = hexVal.toUpperCase();
            }
        };

        /* ════════════ Save (debounced) ════════════ */
        let saveTimer;
        window.tpSave = function () {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function () {
                settings = ThemeEngine.get();
                if (isLoggedIn) {
                    fetch(settingsUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            mode:  settings.mode,
                            light: settings.light,
                            dark:  settings.dark,
                        })
                    })
                    .then(r => r.json())
                    .then(d => { if (d.success) showSaved(); })
                    .catch(console.error);
                } else {
                    showSaved();
                }
            }, 600);
        };

        /* ════════════ UI helpers ════════════ */
        function syncAllUI(s) {
            syncModeButtons(s.mode || 'light');
            syncSectionUI('light', s.light);
            syncSectionUI('dark',  s.dark);
        }

        function syncModeButtons(mode) {
            ['light', 'dark', 'system'].forEach(m => {
                const btn = document.getElementById('tp-btn-' + m);
                if (btn) btn.classList.toggle('active', m === mode);
            });
            const modeIcon = document.getElementById('tp-mode-icon');
            if (modeIcon) {
                modeIcon.textContent = mode === 'dark' ? '🌙' : mode === 'system' ? '🖥️' : '☀️';
            }
        }

        function syncSectionUI(section, palette) {
            if (!palette) return;
            ['bg', 'fg', 'accent'].forEach(key => {
                syncColorUI(section, key, palette[key]);
            });
        }

        function syncColorUI(section, key, hex) {
            if (!hex) return;
            const clean = hex.replace('#', '').toUpperCase();
            const swatchId = 'tp-' + section + '-' + key + '-swatch';
            const hexId    = 'tp-' + section + '-' + key + '-hex';
            const pickId   = 'tp-' + section + '-' + key + '-pick';
            const swatch = document.getElementById(swatchId);
            const hexEl  = document.getElementById(hexId);
            const pickEl = document.getElementById(pickId);
            if (swatch) swatch.style.background = '#' + clean;
            if (hexEl)  hexEl.value = clean;
            if (pickEl) pickEl.value = '#' + clean;
        }

        function showSaved() {
            const ind = document.getElementById('tp-save-indicator');
            if (!ind) return;
            ind.style.display = 'block';
            setTimeout(() => { ind.style.display = 'none'; }, 2000);
        }
    });
})();
</script>
