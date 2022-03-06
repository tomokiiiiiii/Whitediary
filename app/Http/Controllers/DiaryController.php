<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;

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
    
    public function store(Request $request, Diary $diary)
    {
        $input = $request['diary'];
        $diary->fill($input)->save();
        $diary=$diary->latest()->first();
        return redirect()->route('show',$diary->id);
    }
}
