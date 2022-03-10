<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


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
    
  public function seach()
  {
    return view('seach');
  }
  
  public function follow(Request $request)
  {
        $input = $request['search'];
        $user_id=$input['user_id'];
        $name=$input['name'];
        if( DB::table('users')->where('id',$user_id)->where('name',$name)->exists()){
        $user=Auth::user();
        $user->follows()->attach(['followed_user_id'=>$user_id],['following_user_id'=>$user->id]);
        return redirect('/');
        }else{
          return redirect('/seach');
        }
  }
}
