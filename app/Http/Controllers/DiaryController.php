<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Diary;
use App\Http\Requests\DiaryRequest;
use Storage;

class DiaryController extends Controller
{
    public function index(Diary $diary)
    {
        $mydiaries=$diary->where('user_id',Auth::id())->get();
        $yourdiaries=Auth::user()->selectdiaries()->get();
        $alldiaries=[];
        foreach($yourdiaries as $yourdiary){
            array_push($alldiaries,$yourdiary);
        }
        foreach($mydiaries as $mydiary){
             array_push($alldiaries,$mydiary);
        }
        $alldiaries = collect($alldiaries);
        $alldiaries = $alldiaries->sortByDesc('updated_at');
        return view('index')->with(['diaries' => $alldiaries]);
    }
    
    public function show(Diary $diary)
    {
        return view('show')->with(['diary'=>$diary]);
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(DiaryRequest $request, Diary $diary)
    {
        $input = $request['diary'];
        $input +=['user_id'=>$request->user()->id];
        $diary->fill($input);
        $image = $request->file('image');
        if(isset($image)){
        $path = Storage::disk('s3')->putFile('myprefix', $image, 'public');
        $diary->image_path = Storage::disk('s3')->url($path);
        }
        $diary->save();
        return redirect("/select");
    }

}
