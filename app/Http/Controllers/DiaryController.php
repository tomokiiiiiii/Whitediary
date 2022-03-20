<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Diary;
use App\User;
use App\Http\Requests\DiaryRequest;
use Storage;

class DiaryController extends Controller
{
    public function index(Diary $diary)
    {
        $mydiaries=$diary->where('user_id',Auth::id())->get();
        $yourdiaries=Auth::user()->selectdiaries()->get();
        
        
        $alldiaries=[];
        foreach($yourdiaries as $yourdiary){
            array_push($alldiaries,$yourdiary);
        }
        foreach($mydiaries as $mydiary){
            array_push($alldiaries,$mydiary);
        }
        $collectalldiaries = collect($alldiaries);
        $sortalldiaries = $collectalldiaries->sortByDesc('updated_at')->paginate(5);
        //$calldiaries=Auth::user()->selectdiaries()->orderBy('updated_at', 'DESC')->paginate(5);
        //$alldiaries = collect($alldiaries)->sortByDesc('update_at')->paginate(5);
        

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

}
