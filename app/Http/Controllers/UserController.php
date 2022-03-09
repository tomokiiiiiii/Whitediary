<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Auth;

class UserController extends Controller
{
    
  public function index($user_id, User $user)
    {
        $user=User::find($user_id);//where
        $auth=Auth::user()->id;
    return view('mypage')->with([
        'user'=> $user,
        'auth'=>$auth,
        'diaries' => $user->getOwnPaginateByLimit()//dounika
        ]);
    }
  public function delete(Diary $diary_id)
    {
    $diary_id->delete();
    return redirect('/');
    }
}
