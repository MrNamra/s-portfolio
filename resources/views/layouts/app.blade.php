<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{url('fontawesome-free/all.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{url('editor/css/froala_editor.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/froala_style.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/code_view.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/draggable.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/colors.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/emoticons.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/image_manager.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/image.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/line_breaker.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/table.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/char_counter.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/video.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/fullscreen.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/file.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/quick_insert.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/help.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/third_party/spell_checker.css')}}">
        <link rel="stylesheet" href="{{url('editor/css/plugins/special_characters.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.2.7/purify.min.js"></script>

        <script type="text/javascript" src="{{url('editor/js/froala_editor.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/align.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/char_counter.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/code_beautifier.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/code_view.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/colors.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/draggable.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/emoticons.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/entities.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/file.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/font_size.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/font_family.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/fullscreen.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/image.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/image_manager.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/line_breaker.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/inline_style.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/link.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/lists.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/paragraph_format.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/paragraph_style.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/quick_insert.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/quote.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/table.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/save.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/url.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/video.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/help.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/print.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/third_party/spell_checker.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/special_characters.min.js')}}"></script>
        <script type="text/javascript" src="{{url('editor/js/plugins/word_paste.min.js')}}"></script>

        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
