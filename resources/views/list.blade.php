@extends('layouts.app')　　　　　　　　　　　　　　　　　

@section('content')
        <h1>友達一覧</h1>
        <div class='list'>
            @foreach($users as $user)
                <div class='user'>
                    <p class='name'>{{ $follow_user->id }}</p>
                </div>
            @endforeach
            <p class='mypage'><a href="/mypage/{{Auth::id()}}">自分のページ</a></p>
        </div>
        <p class='back'>[<a href='/'>日記画面</a>]</p>
        <div class='paginate'>
        　　{{ $users->links() }}
        </div>

@endsection