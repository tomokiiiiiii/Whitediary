@extends('layouts.app')

@section('content')
    <div class="split-box left-box">
        <p class='follow'><a href='/search'>友達を追加</a></p>
        <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
　　　　<p class='create'><a href='/diaries/create'>書く</a></p>
　　</div>
　　<div class="split-box right-box">
　　    <div class="right-inner">
            <div class='diaries'>
                @foreach($diaries as $diary)
                    <a href="/mypage/{{$diary->user_id}}">{{ $diary->user->name  }}</a>
                    <div class='diary'>
                        <p class='body'>{{ $diary->diary }}</p>
                    </div>
                    @if($diary->image_path)
                        <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
                    @endif
                        {{--投稿日時--}}
    
                        <p class='updated_at'>{{ $diary->updated_at}}</p>
                        {{--like機能--}}
                        <div>
                            @if($diary->is_liked_by_auth_user())
                                <a href="{{ route('diary.unlike', ['id' => $diary->id]) }}" class="btn btn-success btn-sm">いいね</a>
                            @else
                                <a href="{{ route('diary.like', ['id' => $diary->id]) }}" class="btn btn-secondary btn-sm">いいね</a>
                            @endif
                                {{ $diary->likes->count() }}
                        </div>
                @endforeach
            </div>        
        </div>        
         <div class='paginate'>
            {{ $diaries->links() }}
        </div>
    </div>

@endsection