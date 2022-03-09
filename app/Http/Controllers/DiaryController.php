<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Diary;
use App\Http\Requests\PostRequest;
use App\User;

class DiaryController extends Controller
{
    public function index(Diary $diary)
    {
        return view('index')->with(['diaries' => $diary->getPaginateBylimit()]);
    }
    
    public function show(Diary $diary)
    {
        return view('show')->with(['diary'=>$diary]);
    }
    
    public function create()
    {
        return view('create');
    }
    
    public function store(PostRequest $request, Diary $diary)
    {
        $input = $request['diary'];
        $input +=['user_id'=>$request->user()->id];
        $diary->fill($input)->save();
        $diary=$diary->latest()->first();
        return redirect()->route('show',$diary->id);
    }

}
