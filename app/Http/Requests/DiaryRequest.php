<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiaryRequest extends FormRequest
{
    public function rules()
    {
        return [
            //人が３０秒で読むことができるとされている文字数
            'diary.diary' => 'required|string|max:201',
        ];
    }
    
    public function messages()
    {
        return [
            'diary.diary.required'=>'書いてください',
            'diary.diary.max'=>'200文字以下にしてください',
        ];
    }
}
