<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
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
            'text' => 'required | max:5',
            'url' => 'nullable| url | max:5',
            'image' => 'max:3 | nullable',
        ];
    }

    public function attributes()
    {
    return [
        'text' => '回答',
        'url' => 'URL',
        'image' => '画像',
        ];
    }

    public function messages() {
        return [
            'text.required' => ':attributeは入力必須です。',
            'text.max'      => ':attributeは500文字以下で入力してください。',
            'url.max'      => ':attributeは500文字以下で入力してください。',
            'url.url'      => '有効なURLを入力してください。',
            'image.max'      => '3MB以下の画像を選択してください。',
        ];
    }
}
