<div class="theme-card-content" style="font-family: inherit;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; max-width: 600px;">
        <!-- Preset Colors -->
        <div>
            <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Preset Warna Premium</div>
            <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                <!-- Rose Velvet (Default) -->
                <button type="button" onclick="selectPresetColor('#e11d48')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Rose Velvet">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #e11d48; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Velvet</span>
                </button>
                
                <!-- Royal Blue -->
                <button type="button" onclick="selectPresetColor('#2563eb')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Royal Blue">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #2563eb; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Sapphire</span>
                </button>

                <!-- Emerald Green -->
                <button type="button" onclick="selectPresetColor('#059669')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Emerald Forest">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #059669; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Emerald</span>
                </button>

                <!-- Majestic Violet -->
                <button type="button" onclick="selectPresetColor('#7c3aed')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Majestic Violet">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #7c3aed; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Violet</span>
                </button>

                <!-- Crimson Sunset -->
                <button type="button" onclick="selectPresetColor('#ea580c')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Crimson Sunset">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #ea580c; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Crimson</span>
                </button>

                <!-- Ocean Teal -->
                <button type="button" onclick="selectPresetColor('#0d9488')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Ocean Teal">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #0d9488; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Teal</span>
                </button>

                <!-- Amber Gold -->
                <button type="button" onclick="selectPresetColor('#d97706')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Amber Gold">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #d97706; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Amber</span>
                </button>

                <!-- Midnight Gray -->
                <button type="button" onclick="selectPresetColor('#4b5563')" style="border: none; background: none; padding: 0; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; outline: none;" title="Midnight Charcoal">
                    <span style="display: block; width: 36px; height: 36px; border-radius: 50%; background: #4b5563; border: 2px solid var(--border); box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"></span>
                    <span style="font-size: 9px; font-weight: 600; color: var(--text-soft);">Charcoal</span>
                </button>
            </div>
        </div>

        <!-- Custom Color Picker -->
        <div>
            <div style="font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Pilih Warna Kustom</div>
            <div style="display: flex; align-items: center; gap: 16px; background: rgba(0,0,0,0.02); padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border); width: fit-content;">
                <div style="position: relative; width: 36px; height: 36px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border); cursor: pointer;">
                    <input type="color" id="theme-card-color-picker" 
                           style="position: absolute; top: -8px; left: -8px; width: 56px; height: 56px; border: 0; padding: 0; cursor: pointer;"
                           oninput="onCardColorInput(this.value)" 
                           onchange="onCardColorChange(this.value)">
                </div>
                <div>
                    <div style="font-size: 9px; font-weight: 700; color: var(--muted); text-transform: uppercase;">Kode HEX</div>
                    <input type="text" id="theme-card-color-hex" 
                           style="background: transparent; border: 0; padding: 0; font-size: 14px; font-weight: 700; color: var(--text); outline: none; width: 80px; text-transform: uppercase;"
                           placeholder="#000000"
                           onchange="onCardHexTextChange(this.value)">
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div style="display: flex; gap: 12px; align-items: center;">
            <button type="button" onclick="resetCardThemeToDefault()" 
                    style="padding: 10px 20px; border-radius: 8px; border: 1px solid var(--border); background: var(--card-bg); color: var(--text-soft); font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s;"
                    onmouseover="this.style.background='rgba(0,0,0,0.02)'" onmouseout="this.style.background='var(--card-bg)'">
                Reset ke Default
            </button>
            <span id="theme-save-status" style="font-size: 11px; font-weight: 600; color: var(--green); display: none; align-items: center; gap: 4px;">
                ✓ Tersimpan ke profil
            </span>
        </div>
    </div>
</div>

<script>
    (function() {
        const isUserLoggedIn = @json(auth()->check());
        const defaultColor = '#e11d48';

        function syncInputs(color) {
            const picker = document.getElementById('theme-card-color-picker');
            const text = document.getElementById('theme-card-color-hex');
            if (picker) picker.value = color;
            if (text) text.value = color;
        }

        // Initialize inputs on load
        window.addEventListener('DOMContentLoaded', () => {
            const activeColor = localStorage.getItem('theme_color') || defaultColor;
            syncInputs(activeColor);
        });

        // Fallback check if DOMContentLoaded already fired
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            const activeColor = localStorage.getItem('theme_color') || defaultColor;
            syncInputs(activeColor);
        }

        window.onCardColorInput = function(color) {
            if (window.applyThemeColor) {
                window.applyThemeColor(color);
            }
            const text = document.getElementById('theme-card-color-hex');
            if (text) text.value = color;
        };

        window.onCardColorChange = function(color) {
            saveThemeChoiceCard(color);
        };

        window.onCardHexTextChange = function(hex) {
            if (!hex.startsWith('#')) hex = '#' + hex;
            if (/^#[0-9A-F]{6}$/i.test(hex)) {
                if (window.applyThemeColor) {
                    window.applyThemeColor(hex);
                }
                const picker = document.getElementById('theme-card-color-picker');
                if (picker) picker.value = hex;
                saveThemeChoiceCard(hex);
            } else {
                const current = localStorage.getItem('theme_color') || defaultColor;
                syncInputs(current);
            }
        };

        window.selectPresetColor = function(color) {
            if (window.applyThemeColor) {
                window.applyThemeColor(color);
            }
            syncInputs(color);
            saveThemeChoiceCard(color);
        };

        window.resetCardThemeToDefault = function() {
            if (window.applyThemeColor) {
                window.applyThemeColor(defaultColor);
            }
            syncInputs(defaultColor);
            saveThemeChoiceCard(defaultColor);
        };

        function showSaveStatus() {
            const status = document.getElementById('theme-save-status');
            if (status) {
                status.style.display = 'inline-flex';
                setTimeout(() => {
                    status.style.display = 'none';
                }, 2000);
            }
        }

        function saveThemeChoiceCard(color) {
            localStorage.setItem('theme_color', color);
            
            if (isUserLoggedIn) {
                fetch('{{ route('profile.theme.update') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme_color: color })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        showSaveStatus();
                        console.log('Saved custom theme color:', data.theme_color);
                    }
                })
                .catch(err => console.error(err));
            } else {
                showSaveStatus();
            }
        }
    })();
</script>
