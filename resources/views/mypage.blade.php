@extends('layouts.app')

@section('content')
        <h1>日記</h1>
        <p class='follow'>[<a href='/search'>友達を追加</a>]</p>
        <div class='own_diaries'>
            <h2>{{$user->id}}</h2>
            <h1>{{ $user->name }}</h1> 
            @foreach($diaries as $diary)
                <div class='diary'>
                    {{-- showに飛ぶリンク --}}
                    <a href="/select/{{$diary->id}}">
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                    </a>
                </div>
            @if ($diary->image_path)
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
                @if($user->id==$auth_id)
                    <form action="/mypage/{{ $diary->id }}" id="form_{{ $diary->id }}" method="post" style="display:inline">
                    @csrf
                    @method('DELETE')
                        <button type="submit">記事削除</button> 
                    </form>
                @endif
            @endforeach
            @if($user->id==$auth_id)
            <div class='list'>[<a href='/list'>リスト</a>]</div>
            @endif
        </div>
        <p class='back'>[<a href='/'>日記画面</a>]</p>
        <div class='paginate'>
            {{ $diaries->links() }}
        </div>
@endsection
