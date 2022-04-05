<?php

namespace App\Http\Controllers;
use App\User;
use App\Diary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\FollowUser;
use App\DiaryUser;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    
  public function mypage(User $user,Request $request,Diary $diary)
  {
    $auth_id=Auth::user()->id;
    if($user->id==$auth_id){
      //mypageのユーザーとログイン主が同じだった時の挙動
      $diaries=new Diary;
      $diaries=Diary::where('user_id',Auth::user()->id)->orderBy('updated_at','DESC')->paginate(5);
      
      return view('mypage')->with([
      'user'=>$user,
      'auth_id'=>$auth_id,
      'diaries' => $diaries,
      ]);
    }
    
    else{
      if(!DB::table('follow_users')->where('following_user_id',Auth::id())->where('followed_user_id',$user->id)->exists()){
        return view('error');
      }
    }
    
      //mypageのユーザーとログイン主が違う時の挙動
      //diariestableとdiary_usertableの被り
      $selectdiaries=DB::table('diary_user')->groupBy('diary_id')->get('diary_id');
      $selectdiary_id=[];
      foreach($selectdiaries as $selectdiary){
        array_push($selectdiary_id,$selectdiary->diary_id);
      }

      //worlddiariesにdiariestableとdiary_usertableを入れる
      $worlddiaries=[];
      //diariestableとdiary_usertableの被りを抜くselectしたidのみ表示
      $alldiaries=$diary->whereNotIn('id',$selectdiary_id)->where('user_id',$user->id)->get();
      $follow_user_ids=Auth::user()->follows()->get();
      $follow_diaries=[];
        foreach($follow_user_ids as $follow_user_id){
          array_push($follow_diaries,$follow_user_id->id);
        }
        
        foreach($alldiaries as $alldiary){
          if(in_array($alldiary->user_id,$follow_diaries)){
              array_push($worlddiaries,$alldiary);
          }else if($alldiary->user_id==Auth::id()){
              array_push($worlddiaries,$alldiary);
            }
          }

      $yourdiaries=Auth::user()->selectdiaries()->get();
        foreach($yourdiaries as $yourdiary){
          array_push($worlddiaries,$yourdiary);
        }
    

     $collectalldiaries = collect($worlddiaries);
    $diaries = $collectalldiaries->sortByDesc('updated_at')->paginate(5);

    return view('mypage')->with([
      'user'=>$user,
      'auth_id'=>$auth_id,
      'diaries' => $diaries,
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
          if(!DB::table('follow_users')->where('following_user_id',Auth::id())->where('followed_user_id',$user_id)->exists()){
            if($user_id!=Auth::id()){
              $user=Auth::user();
              $user->follows()->attach(['followed_user_id'=>$user_id],['following_user_id'=>$user->id]);
              return redirect('/');
            }
          }
        }
        return redirect('/search');
        
  }
  public function listfollowing(FollowUser $followUser)
  {
    $user=Auth::user()->follows()->get();
    return view('listfollowing')->with(['following_user_ids' => $user]);
  }
  
  public function listfollowed(FollowUser $followUser)
  {
    $user=Auth::user()->followUsers()->get();;
    return view('listfollowed')->with(['followed_user_ids' => $user]);
  }
  
  public function following_delete(User $user)
  {
    $user_id=Auth::id();
    $user->followUsers()->detach(['following_user_id'=>$user_id]);
   
    
    return redirect('/listfollowing');
  }
  
  public function followed_delete(User $user)
  {
    $user_id=Auth::id();
    $user->follows()->detach(['followed_user_id'=>$user_id]);
   
    
    return redirect('/listfollowed');
  }
  
  public function select_user(User $user)
  {
    $user=Auth::user();
    $allowed_users =$user->followUsers()->get();
    return view('/select')->with(['followed_users_id' => $allowed_users]);
   
  }
  
  public function store(UserRequest $request)
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

