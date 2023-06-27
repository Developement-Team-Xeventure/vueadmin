<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin - {{ !empty($title) ? $title :ucfirst(request()->route()->getName())  }}</title>

    {{-- @include('components/styles') --}}

     @vite('resources/css/app.css')


</head>

<body class="antialiased">

    {{-- @include('components/navbar')
        <main  class=" pt-5">
            @yield('frontend')
        </main>
    @include('components/footer')
    @include('components.script') --}}

    <div id="app">

            <router-view></router-view>
    </div>







    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}",
            user: {!! json_encode(auth('api')->user()) !!},
            jsPermissions: {!! Auth::check() ? Auth::user()->jsPermissions() : 'null' !!}
        };
    </script>

    @vite('resources/js/app.js' )
    
</body>
<noscript>Sorry, your browser does not support JavaScript!</noscript>


</html>
