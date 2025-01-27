<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        @php $setting = \Helper::getSetting() @endphp
        @if(!empty($setting['software_favicon']))
            <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/storage/' . $setting['software_favicon']) }}">
        @endif

        <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700&family=Roboto+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100&display=swap" rel="stylesheet">        <title>{{ env('APP_NAME') }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php $custom = \Helper::getCustom() @endphp
        <style>
            body{
                font-family: {{ $custom['font_family_default'] ?? "'Roboto Condensed', sans-serif" }};
            }
            :root {
                --ci-primary-color: {{ $custom['primary_color'] }};
                --ci-primary-opacity-color: {{ $custom['primary_opacity_color'] }};
                --ci-secundary-color: {{ $custom['secundary_color'] }};
                --ci-gray-dark: {{ $custom['gray_dark_color'] }};
                --ci-gray-light: {{ $custom['gray_light_color'] }};
                --ci-gray-medium: {{ $custom['gray_medium_color'] }};
                --ci-gray-over: {{ $custom['gray_over_color'] }};
                --title-color: {{ $custom['title_color'] }};
                --text-color: {{ $custom['text_color'] }};
                --sub-text-color: {{ $custom['sub_text_color'] }};
                --placeholder-color: {{ $custom['placeholder_color'] }};
                --background-color: {{ $custom['background_color'] }};
                --standard-color: #1C1E22;
                --shadow-color: #111415;
                --page-shadow: linear-gradient(to right, #111415, rgba(17, 20, 21, 0));
                --autofill-color: #f5f6f7;
                --yellow-color: #FFBF39;
                --yellow-dark-color: #d7a026;
                --border-radius: {{ $custom['border_radius'] }};
                --tw-border-spacing-x: 0;
                --tw-border-spacing-y: 0;
                --tw-translate-x: 0;
                --tw-translate-y: 0;
                --tw-rotate: 0;
                --tw-skew-x: 0;
                --tw-skew-y: 0;
                --tw-scale-x: 1;
                --tw-scale-y: 1;
                --tw-scroll-snap-strictness: proximity;
                --tw-ring-offset-width: 0px;
                --tw-ring-offset-color: #fff;
                --tw-ring-color: rgba(59,130,246,.5);
                --tw-ring-offset-shadow: 0 0 #0000;
                --tw-ring-shadow: 0 0 #0000;
                --tw-shadow: 0 0 #0000;
                --tw-shadow-colored: 0 0 #0000;

                --input-primary: {{ $custom['input_primary'] }};
                --input-primary-dark: {{ $custom['input_primary_dark'] }};

                --carousel-banners: {{ $custom['carousel_banners'] }};
                --carousel-banners-dark: {{ $custom['carousel_banners_dark'] }};


                --sidebar-color: {{ $custom['sidebar_color'] }} !important;
                --sidebar-color-dark: {{ $custom['sidebar_color_dark'] }} !important;


                --navtop-color {{ $custom['navtop_color'] }};
                --navtop-color-dark: {{ $custom['navtop_color_dark'] }};


                --side-menu {{ $custom['side_menu'] }};
                --side-menu-dark: {{ $custom['side_menu_dark'] }};

                --footer-color {{ $custom['footer_color'] }};
                --footer-color-dark: {{ $custom['footer_color_dark'] }};

                --card-color {{ $custom['card_color'] }};
                --card-color-dark: {{ $custom['card_color_dark'] }};
            }
            .navtop-color{
                background-color: {{ $custom['sidebar_color'] }} !important;
            }
            :is(.dark .navtop-color) {
                background-color: {{ $custom['sidebar_color_dark'] }} !important;
            }

            .bg-base {
                background-color: {{ $custom['background_base'] }};
            }
            :is(.dark .bg-base) {
                background-color: {{ $custom['background_base_dark'] }};
            }
        </style>

        @if(!empty($custom['custom_css']))
            <style>
                {!! $custom['custom_css'] !!}
            </style>
        @endif

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body color-theme="dark" class="bg-base text-gray-800 dark:text-gray-300 ">
        <div id="viperpro"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/datepicker.min.js"></script>
        <script>
            window.Livewire?.on('copiado', (texto) => {
                navigator.clipboard.writeText(texto).then(() => {
                    Livewire.emit('copiado');
                });
            });

            window._token = '{{ csrf_token() }}';
            //if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.remove('dark')
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.remove('light')
                document.documentElement.classList.add('dark')
            }
        </script>

        @if(!empty($custom['custom_js']))
            <script>
                {!! $custom['custom_js'] !!}
            </script>
        @endif

    </body>
</html>
