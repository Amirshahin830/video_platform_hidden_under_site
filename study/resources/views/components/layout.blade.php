<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="caramellatte">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font@latest/dist/font-face.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/plyr@3/dist/plyr.css">
{{--    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />--}}
    <title>{{$title ?? 'My Blog'}}</title>

</head>

<body>

<x-navbar/>

<main >
    {{ $slot }}
</main>
<script src="https://cdn.jsdelivr.net/npm/plyr@3/dist/plyr.js"></script>


</body>
</html>
