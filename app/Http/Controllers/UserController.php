<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\FollowUser;

class UserController extends Controller
{
    
  public function index(User $user)
    {
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
    
  public function search()
  {
    return view('search');
  }
  
  public function follow(Request $request)
  {
        $input = $request['search'];
        $user_id=$input['user_id'];
        $name=$input['name'];
        if( DB::table('users')->where('id',$user_id)->where('name',$name)->exists()){
        $user=Auth::user();
        //kokodeera-
        $user->follows()->attach(['followed_user_id'=>$user_id],['following_user_id'=>$user->id]);
        return redirect('/');
        }else{
          return redirect('/search');
        }
  }
  public function list(FollowUser $followUser)
  {
    $user=Auth::user();
   return view('list')->with(['following_user_ids' => $user]);
  }
  
  public function follows_delete(User $user)
    {
      $user_id=Auth::id();
      $user->followUsers()->detach(['following_user_id'=>$user_id]);
      // $followUser->delete();
    
    return redirect('/list');
    }
    
  public function select_user()
  {
    
  }
}

