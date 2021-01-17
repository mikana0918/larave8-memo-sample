<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //ユーザーがリクエストを行うことができるか
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'nullable|numeric', //notes.idはnullもしくは数字(numeric)である
            'note_contents' => 'max:140' //note_contentsの最大長は140字
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'note_contents.max' => '本文は140字以下にしてください。', //note_contentsのmaxバリデーションの際のエラーメッセージ
        ];
    }
}
