<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'name' => 'required | max:20',
            'age' => 'integer | nullable',
            'bio' =>  'max:200 | nullable',
            'image' => 'max:3000000 | nullable'
        ];
    }

    public function attributes()
    {
    return [
        'name' => 'アカウント名',
        'age' => '年齢',
        'bio' => '自己紹介',
        'image' => 'プロフィール画像',
        ];
    }

    public function messages() {
        return [
            'name.required' => ':attributeは入力必須です。',
            'name.max'      => ':attributeは20文字以下で入力してください。',
            'age.integer'      => ':attributeは数値で入力してください。',
            'bio.max'      => ':attributeは200文字以下で入力してください。',
            'image.max'      => '3MB以下の画像を選択してください。',
        ];
    }
}
