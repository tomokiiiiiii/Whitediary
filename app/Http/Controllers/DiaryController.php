<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Diary;
use App\User;
use App\Http\Requests\DiaryRequest;
use Storage;
use App\Like;

class DiaryController extends Controller
{
    public function index(Diary $diary)
    {
        // dd(Auth::user()->checkfollowing(Auth::user()));
        
        $indexdiaries=[];
        //diarytableがauthuserの日記全部1
        $authdiaries=$diary->Where('user_id',Auth::id())->get();
        foreach($authdiaries as $authdiary){
            array_push($indexdiaries,$authdiary);
        }
        
        //diary_usertableでauthuserがある日記全部2
        $authdiary_users_id=DB::table('diary_user')->Where('user_id',Auth::id())->get();
        foreach($authdiary_users_id as $authdiary_user_id){
            $authdiary_user=$diary->Where('id',$authdiary_user_id->diary_id)->first();
            array_push($indexdiaries,$authdiary_user);
        }
        
        //diary_usertableにないfollowしている人の日記全部
        //follow_usersの友達追加した人のid
        $following_users_id=DB::table('follow_users')->Where('following_user_id',Auth::id())->get('followed_user_id');
        $following_users=[];
        foreach($following_users_id as $following_user_id){
            array_push($following_users,$following_user_id->followed_user_id);
        }
        
        //diary_usertableにある日記全て
        $alldiaries_user_id=DB::table('diary_user')->get('diary_id');
        $alldiaries_user=[];
        foreach($alldiaries_user_id as $alldiary_user_id){
            array_push($alldiaries_user,$alldiary_user_id->diary_id);
        }
        
        //diary_usertableを除いたfollowしている人の日記3
        $alldiaries=$diary->WhereNotIn('id',$alldiaries_user)->Where('user_id',$following_users)->get();
        foreach($alldiaries as $alldiary){
            array_push($indexdiaries,$alldiary);
        }
        //123の日記合体
        $collectalldiaries = collect($indexdiaries);
        $sortalldiaries = $collectalldiaries->sortByDesc('updated_at')->paginate(5);
        
        return view('index')->with(['diaries' => $sortalldiaries]);
    }
    
    
    public function show(Diary $diary)
    {
        $auth_id=Auth::user()->id;
        if($diary->user_id==$auth_id){
        //showのユーザーとログイン主が同じだった時の挙動
        $users_id=DB::table('diary_user')->where('diary_id',$diary->id)->get('user_id');
        $name=[];
        foreach($users_id as $user_id){
            $user= new User;
            $user_name=$user->where('id',$user_id->user_id)->first()->name;
            array_push($name,$user_name);
        }
        return view('show')->with([
            'diary'=>$diary,
            'names'=>$name,
        ]);
        }
        
        else{
            if(!DB::table('follow_users')->where('following_user_id',Auth::id())->where('followed_user_id',$diary->user_id)->exists()){
                return view('error');
            }
            elseif((DB::table('diary_user')->where('diary_id',$diary->id)->exists())&&(!DB::table('diary_user')->where('diary_id',$diary->id)->where('user_id',Auth::id())->exists())){
                return view('error');
            }
        }
        
        
        //showのユーザーとログイン主が違う時の挙動
        return view('show')->with([
            'diary'=>$diary,
            'names'=>[],
        ]);
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
   //lile
   public function like($id)
   {
     //書き方少し違う
        Like::create([
        'diary_id' => $id,
        'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'You Liked the Diary.');

        return redirect()->back();
    }
  
    //like解除
    public function unlike($id)
    {
        $like = Like::where('diary_id', $id)->where('user_id', Auth::id())->first();
        $like->delete();
        session()->flash('success', 'You Unliked the Diary.');

        return redirect()->back();
    }

   
   public function likelist(Diary $diary,Like $like)
   {
        $likelist=$like->where('diary_id',$diary->id)->get();
        
        return view('likelist')->with([
            'likelists'=>$likelist,
            'diary'=>$diary,
            'names'=>[],
        ]);
   }
   
}
