<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
@stack('seo')
<title>@yield('title', 'SpecWise | Compare Intelligently with AI')</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet"/>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                "colors": {
                    "background": "#faf8ff",
                    "surface-tint": "#0054d6",
                    "tertiary-fixed": "#e0e3e5",
                    "surface-container-highest": "#dae2fd",
                    "primary-fixed": "#dae1ff",
                    "tertiary": "#565a5b",
                    "on-surface": "#131b2e",
                    "surface-container": "#eaedff",
                    "on-primary-fixed": "#001849",
                    "inverse-on-surface": "#eef0ff",
                    "outline-variant": "#c2c6d8",
                    "surface-dim": "#d2d9f4",
                    "outline": "#727687",
                    "primary-container": "#0066ff",
                    "on-secondary": "#ffffff",
                    "on-secondary-container": "#fffbff",
                    "on-surface-variant": "#424656",
                    "surface-bright": "#faf8ff",
                    "error": "#ba1a1a",
                    "on-background": "#131b2e",
                    "surface-container-low": "#f2f3ff",
                    "primary": "#0050cb",
                    "on-primary-fixed-variant": "#003fa4",
                    "inverse-surface": "#283044",
                    "on-primary-container": "#f8f7ff",
                    "on-tertiary": "#ffffff",
                    "surface-container-lowest": "#ffffff",
                    "secondary-fixed": "#f0dbff",
                    "primary-fixed-dim": "#b3c5ff",
                    "on-primary": "#ffffff",
                    "on-error-container": "#93000a",
                    "secondary": "#8127cf",
                    "inverse-primary": "#b3c5ff",
                    "surface-container-high": "#e2e7ff",
                    "surface": "#faf8ff",
                    "secondary-container": "#9c48ea",
                    "on-tertiary-fixed": "#191c1e",
                    "surface-variant": "#dae2fd",
                    "secondary-fixed-dim": "#ddb7ff",
                    "tertiary-container": "#6f7274",
                    "on-error": "#ffffff",
                    "error-container": "#ffdad6"
                },
                "borderRadius": {
                    "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"
                },
                "spacing": {
                    "margin-mobile": "16px", "gutter": "24px",
                    "margin-desktop": "40px", "base": "8px", "container-max": "1280px"
                },
                "fontFamily": {
                    "mono-data": ["Inter"], "display-lg-mobile": ["Outfit"],
                    "body-md": ["Inter"], "body-lg": ["Inter"],
                    "headline-md": ["Outfit"], "label-caps": ["Inter"], "display-lg": ["Outfit"]
                },
                "fontSize": {
                    "mono-data": ["14px", {"lineHeight": "20px", "fontWeight": "500"}],
                    "display-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "headline-md": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "label-caps": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                    "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                }
            },
        },
    }
</script>
<style>
    .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    .ai-glow { position: relative; }
    .ai-glow::after {
        content: ''; position: absolute; inset: -1px; border-radius: inherit; padding: 1px;
        background: linear-gradient(to right, #0066ff, #8127cf);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; opacity: 0.6;
    }
    .ai-glow-soft { box-shadow: 0 0 15px rgba(0,102,255,0.15), 0 0 15px rgba(129,39,207,0.15); }
    .shimmer { background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); background-size: 200% 100%; animation: shimmer 3s infinite; }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24; vertical-align: middle; }
</style>
@stack('styles')
</head>
<body class="bg-background text-on-surface font-body-md selection:bg-primary/20">

{{-- Navigation --}}
@include('components.nav')

{{-- Page Content --}}
@yield('content')

{{-- Footer --}}
@include('components.footer')

@stack('scripts')
</body>
</html>
