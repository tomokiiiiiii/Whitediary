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
        //diariestableとdiary_usertableの被り
        $selectdiaries=DB::table('diary_user')->groupBy('diary_id')->get('diary_id');
        $selectdiary_id=[];
            foreach($selectdiaries as $selectdiary){
                array_push($selectdiary_id,$selectdiary->diary_id);
            }
        //worlddiariesにdiariestableとdiary_usertableを入れる
        $worlddiaries=[];
            //diariestableとdiary_usertableの被りを抜く
            $alldiaries=$diary->whereNotIn('id',$selectdiary_id)->get();
    
            //followingのidを持ってくる
            $follow_user_ids=Auth::user()->follows()->get();
        
            //followingの日記
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
        
            //自分の日記
            $mydiaries=$diary->whereIn('id',$selectdiary_id)->get();

            $myselectdiaries=$diary->whereNotIn('id',$selectdiary_id)->get('id');
            $myselectdiary_id=[];
                foreach($myselectdiaries as $myselectdiary){
                    array_push($myselectdiary_id,$myselectdiary->id);
                }
            $mydiaries=$diary->whereNotIn('id',array_merge($selectdiary_id,$myselectdiary_id))->where('user_id',Auth::id())->get();
        
            //見せられる日記
            $yourdiaries=Auth::user()->selectdiaries()->get();
            foreach($yourdiaries as $yourdiary){
                array_push($worlddiaries,$yourdiary);
            }
            foreach($mydiaries as $mydiary){
                array_push($worlddiaries,$mydiary);
            }
            
        $collectalldiaries = collect($worlddiaries);
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

}
