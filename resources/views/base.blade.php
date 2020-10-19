<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>[MailView] @yield('title')</title>

    <link href="https://unpkg.com/tailwindcss@1.9.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans leading-none text-gray-900 antialiased bg-gray-100">

    <div class="px-20 mt-10">

        @yield('content')

    </div>

    <div class="text-center text-gray-500 mt-20 mb-12">
        <span class="text-gray-600">Laravel MailView</span>
        <span class="px-2">&#10045;</span>
        <a class="hover:underline" href="https://www.github.com/julienbourdeau/laravel-mail-view">GitHub</a>
        <span class="px-2">&#10045;</span>
        <a class="hover:underline" href="https://www.sigerr.org/docs/laravel-mail-view">Docs</a>
        <span class="px-2">&#10045;</span>
        <a class="hover:underline" href="https://www.sigerr.org" title="Julien Bourdeau">Author</a>
    </div>

    @if(\Illuminate\Support\Facades\View::exists('mail-view::scripts'))
        @include('mail-view::scripts')
    @endif
</body>
</html>
