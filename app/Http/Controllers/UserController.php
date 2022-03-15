<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\FollowUser;
use App\DiaryUser;

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
    //外に出す意味は？getbylimit
    $user_id=Auth::id();
    $user->followUsers()->detach(['following_user_id'=>$user_id])->getPaginateByLimit();
      // $followUser->delete();
    
    return redirect('/list');
  }
    
  public function select_user(User $user)
  {
    $user=Auth::user();
    $allowed_users =$user->followUsers()->get();
    return view('/select')->with(['followed_users_id' => $allowed_users]);
   
  }
  
  public function store(Request $request)
  {
    $select_users= $request->users_array;
    $user=Auth::user();
    $all_diaries=$user->diaries();
    $latestdiary=$all_diaries->orderBy('updated_at','DESC')->limit(1)->first()->id;
    foreach($select_users as $select_user){
      $user->selectdiaries()->attach(['diary_id'=>$latestdiary],['user_id'=>$select_user]);
    }
    return redirect('/select/'.$latestdiary)->with(['latestdiary' => $latestdiary]);
    }
  public function cancel()
    {
    $user=Auth::user();
    $all_diaries=$user->diaries();
    $latestdiary=$all_diaries->orderBy('updated_at','DESC')->limit(1)->first();
    $latestdiary->delete();
    return redirect('/');
    }
}

