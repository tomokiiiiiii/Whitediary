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
        $alldiary=[];
        foreach($yourdiaries as $yourdiary){
            array_push($alldiary,$yourdiary);
        }
        foreach($mydiaries as $mydiary){
             array_push($alldiary,$mydiary);
        }
        
        return view('index')->with(['diaries' => $alldiary]);
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
