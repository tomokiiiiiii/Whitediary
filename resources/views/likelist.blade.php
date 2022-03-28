@extends('layouts.app')

@section('content')
    <div class="likelist">
        <h1>いいねリスト</h1>
        @foreach($likelists as $likelist)
            <p>{{$likelist->user->name}}</p>
        @endforeach
    </div>
    <a href="/select/{{$diary->id}}">ひとつ戻る</a>
    <div class='back'>[<a href='/'>日記画面</a>]</div>
@endsection