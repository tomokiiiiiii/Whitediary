@extends('layouts.app')

@section('content')
<div class="split-box show-left-box">
    <div class="left-top">
        @if($user->id==$auth_id)
        <h2>{{$user->id}}</h2>
        @endif
        <h1>{{ $user->name }}</h1>
    </div>
    <div class="left-bottom">
        <p class='follow'><a href='/search'>友達を追加</a></p>
        @if($user->id==$auth_id)
            <p class='listfollowing'><a href='/listfollowing'>見たい人リスト</a></p>
            <p class='listfollowed'><a href='/listfollowed'>見せたいリスト</a></p>
        @endif
        <p class='home'><a href='/'>日記画面</a></p>
    </div>
</div>
<div class="split-box right-box">
    <div class='own_diaries'>
        @foreach($diaries as $diary)
            <div class='mydiary'>
                {{-- showに飛ぶリンク --}}
                <a href="/select/{{$diary->id}}">
                    <p class='mypagebody'>{{ $diary->diary }}</p>
                    @if ($diary->image_path)
                        <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
                    @endif
                        {{--投稿日時--}}
                        <p class='updated_at'>{{ $diary->updated_at}}</p>
                        {{--like機能--}}
                    <div class="like">
                        @if($diary->is_liked_by_auth_user())
                            <a href="{{ route('diary.unlike', ['id' => $diary->id]) }}" class="btn btn-success btn-lg">いいね</a>
                            @else
                            <a href="{{ route('diary.like', ['id' => $diary->id]) }}" class="btn btn-secondary btn-lg">いいね</a>
                        @endif
                        {{ $diary->likes->count() }}
                    </div>
                    <div class="delete">
                        @if($user->id==$auth_id)
                            <form action="/mypage/{{ $diary->id }}" id="form_{{ $diary->id }}" method="post" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onClick="delete_alert(event);return false;">記事削除</button>
                            </form>
                        @endif
                    </div>
                </a>
              </div>    
        @endforeach
    </div>
    <div class="pagination pagination-lg">
        {{ $diaries->links() }}
    </div>
</div>    
@endsection