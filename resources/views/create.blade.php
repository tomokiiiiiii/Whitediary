@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <div class="creatediary">
        <h1>日記作成</h1>
        <h2>日記内容　200文字</h2>
        <form action="/diaries" method="POST"　enctype="multipart/form-data">
            @csrf
            <div class="diarybox">
                <textarea name="diary[diary]" placeholder="できごと"　onkeyup="ShowLength(value);"/>{{ old('diary.diary') }}</textarea>
                <p id="inputlength">0文字</p>
                <p class="diary_error" style="color:red">{{ $errors->first('diary.diary') }}</p>
            </div>
            <div class="image">
                <h2>写真</h2>
                <input type="file"  name="image" accept="image/jpeg,image/png,image/gif">
            </div>
                <input type="submit" class="btn btn-primary btn-lg" value="選ぶ">
        </form>
        <div class="createback"><a href="/">戻る</a></div>
        
    </div>
@endsection