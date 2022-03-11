@extends('layouts.app')　　　　　　　　　　　　　　　　　

@section('content')
        <h1>日記</h1>
        <div class='own_diaries'>
            <h2>{{ $user->name }}</h2> 
            <h4>{{$user->id}}</h4>
            @foreach($diaries as $diary)
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
        　　@if($diary->user_id==$auth)
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
            @if($diary->user_id==$auth)
            <div class='list'>[<a href='/list'>リスト</a>]</div>
            @endif
        </div>
        <p class='back'>[<a href='/'>日記画面</a>]</p>
        <div class='paginate'>
        　　{{ $diaries->links() }}
        </div>

@endsection
