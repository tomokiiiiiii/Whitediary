@extends('layouts.app')

@section('content')
        <h1>日記</h1>
        <div class='diary'>
            <h2 class='user_id'>{{ $diary->user->name  }}</h2>
            <p class='body'>{{ $diary->diary }}</p>
            <p class='updated_at'>{{ $diary->updated_at}}</p>
            @foreach($names as $name)
            <p class='name'>{{ $name }}</p>
            @endforeach
        </div>
        @if($diary->image_path)
            <img src="{{ $diary->image_path }}">
        @endif
        {{--like機能--}}
        <div>
            @if($diary->is_liked_by_auth_user())
            <a href="{{ route('diary.unlike', ['id' => $diary->id]) }}" class="btn btn-success btn-sm">いいね<span class="badge">{{ $diary->likes->count() }}</span></a>
            @else
            <a href="{{ route('diary.like', ['id' => $diary->id]) }}" class="btn btn-secondary btn-sm">いいね<span class="badge">{{ $diary->likes->count() }}</span></a>
            @endif
            {{ $diary->likes->count() }}
        </div>
        <div class='back'>[<a href='/'>日記画面</a>]</div>
@endsection

