<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;

class UserController extends Controller
{
    
  public function index($user_id, User $user)
    {
        $user=User::find($user_id);//where
        $diaries=$user->diary;//リレーション？？
    return view('mypage')->with([
        'user'=> $user,
        'diaries'=>$diaries,
        'own_diaries' => $user->getOwnPaginateByLimit()//dounika
        ]);
    }
}