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
        <form action="/diaries" method="POST">
            {{ csrf_field() }}
            <div class="diary">
                <h2>日記内容</h2>
                <textarea name="diary[diary]" placeholder="できごと"></textarea>
            </div>
            <input type="submit" value="投稿"/>
        </form>
        <div class="back">[<a href="/">戻る</a>]</div>
    </body>
</html>
