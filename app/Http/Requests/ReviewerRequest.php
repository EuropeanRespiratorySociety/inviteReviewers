<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReviewerRequest extends Request
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
            /*example
        return [
            'title' => 'required|min:5',
            'body' => 'required|min:25',
            'published_at' => 'required|date',
            ];*/
        ];
    }
}
