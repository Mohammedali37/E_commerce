<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProduct extends FormRequest
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
            'title' => 'required',

            'description' => 'required',
            'thumbnail' => 'required | mimes:jpeg,jpg,bmp,png,size:2048',
            'status' => 'required| numeric',
            'category_id' => 'required',
            'price' => 'required | numeric'
        ];
    }
}
