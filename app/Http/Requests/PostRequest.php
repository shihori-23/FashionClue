<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'text' => 'required|max:500',
            'image' => 'max:3000000|nullable'
        ];
    }

    public function attributes()
    {
    return [
        'text' => '回答',
        'image' => '画像',
        ];
    }

    public function messages() {
        return [
            'text.required' => ':attributeは入力必須です。',
            'text.max'      => ':attributeは最低500文字以上で入力してください。',
            'image.max'      => '3MB以下の画像を選択してください。',
        ];
    }
}
