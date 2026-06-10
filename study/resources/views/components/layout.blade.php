<!DOCTYPE html>
<html lang="fa" dir="rtl" data-theme="dark">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css">

    <title>{{$title ?? 'My Blog'}}</title>
</head>
<body class="font-sans leading-relaxed text-base-content">

@props(['logo' => null, 'pageTitle' => 'My Coffee Blog', 'chat_roll' => false])
<x-navbar
    :chat_roll="$chat_roll"
    :pageTitle="$pageTitle"
    :logo="$logo"/>

<main >
    {{ $slot }}
</main>


</body>
</html>
