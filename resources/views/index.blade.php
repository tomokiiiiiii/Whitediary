@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <h1>日記</h1>
        <p class='follow'>[<a href='/search'>友達を追加</a>]</p>
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
　　　　<p class='create'>[<a href='/diaries/create'>書く</a>]</p>
        <div class='diaries'>
            @foreach($diaries as $diary)
                    <a href="/mypage/{{$diary->user->id}}">{{ $diary->user->name  }}</a>
                <div class='diary'>
                    {{--<a href="/select/{{$diary->id}}"> --}}
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                    {{-- </a> --}}
                </div>
                @if($diary->image_path)
                <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
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
            @endforeach
        </div>
        <div class='paginate'>
            {{ $diaries->links() }}
        </div>

@endsection