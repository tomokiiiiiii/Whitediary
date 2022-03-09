@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
    <body>
        <h1>日記</h1>
         <p class='create'>[<a href='/diaries/create'>書く</a>]</p>
        <div class='diaries'>
            @foreach($diaries as $diary)
                <a href="/mypage/{{$diary->user->id}}">{{ $diary->user->name  }}</a>
                <div class='diary'>
                    <p class='body'>{{ $diary->diary }}</p>
                    <p class='updated_at'>{{ $diary->updated_at}}</p>
                </div>
                @if ($diary->image_path)
                <img width=60% src="{{ $diary->image_path }}" class="img-responsive">
                @endif
            @endforeach
        </div>
        <div class='paginate'>
        　　{{ $diaries->links() }}
        </div>
    </body>
</html>

@endsection
