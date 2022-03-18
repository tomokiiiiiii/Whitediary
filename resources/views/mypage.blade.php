@extends('layouts.app')　　　　　　　　　　　　　　　　　

@section('content')
        <h1>日記</h1>
        <p class='follow'>[<a href='/search'>友達を追加</a>]</p>
        <div class='own_diaries'>
            <h2>{{$user->id}}</h2>
            <h1>{{ $user->name }}</h1> 
            @foreach($diaries as $diary)
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
        　　@if($user->id==$auth_id)
             <form action="/mypage/{{ $diary->id }}" id="form_{{ $diary->id }}" method="post" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">記事削除</button> 
             </form>
            @endif
            @if ($diary->image_path)
                <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
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
