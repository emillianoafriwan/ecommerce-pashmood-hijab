@php
    /* ── Resolve server-side saved settings ── */
    $themeSettings = null;
    $themeColor    = '#e11d48';
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->theme_settings) {
            $themeSettings = $user->theme_settings;
        }
        if ($user->theme_color) {
            $themeColor = $user->theme_color;
        }
    }
@endphp

{{-- Load Theme Engine (self-contained, reads localStorage) --}}
<script src="{{ asset('js/theme-engine.js') }}"></script>

@if($themeSettings)
{{-- Merge server-saved settings so first-paint matches DB (no flash) --}}
<script>
(function(){
    var saved  = @json($themeSettings);
    var stored = null;
    try { stored = JSON.parse(localStorage.getItem('pashmood_theme_v2')); } catch(e){}
    // Only push server settings if localStorage is empty or stale
    if (!stored) {
        localStorage.setItem('pashmood_theme_v2', JSON.stringify(saved));
    }
    if (window.ThemeEngine) {
        window.ThemeEngine.apply(stored || saved);
    }
})();
</script>
@endif
