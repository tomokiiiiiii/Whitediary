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
}
