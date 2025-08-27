<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', 'Furniture Max')
    </title>
    <link rel="stylesheet" href="{{ asset('assets/css/components/master.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="{{asset('assets/img/icon.png')}}" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @hasSection ('css-style')
        @yield('css-style')
    @endif
</head>
<body>
    @include('components.page.navbar')
    @yield('content')

    @hasSection ('about-us')
        @include('components.page.tentang')
    @endif

    @hasSection ('footer')
        @include('components.page.footer')
    @endif
    @hasSection ('js-scripts')
        @yield('js-scripts')
    @endif
</body>
</html>