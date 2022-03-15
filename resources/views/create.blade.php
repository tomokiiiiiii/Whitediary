@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
        <h1>日記</h1>
        <form action="/diaries" method="POST"　enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="diary">
                <h2>日記内容</h2>
                <textarea name="diary[diary]" placeholder="できごと"　value="{{ old('diary.diary') }}"/></textarea>
                <p class="diary_error" style="color:red">{{ $errors->first('diary.diary') }}</p>
            </div>
            <div class="image">
                <h2>写真</h2>
               <input type="file" name="image">
            </div>
            <input type="submit" value="選ぶ">
        </form>
        <div class="back">[<a href="/">戻る</a>]</div>
@endsection