<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>みんなの日記</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <h1>日記</h1>
        <div class='diaries'>
            @foreach($diaries as $diary)
                <div class='diary'>
                    <h2 class='user_id'>{{ $diary->id }}</h2>
                    <p class='body'>{{ $diary->diary }}</p>
                </div>
            @endforeach
        </div>
    </body>
</html>
