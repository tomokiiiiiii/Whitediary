<?php

namespace App\Http\Controllers;

use App\Diary;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function index(Diary $diary)
    {
        return view('index')->with(['diaries' => $diary->get()]);
    }
}
