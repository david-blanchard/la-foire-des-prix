<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            "name" => "required|min:15|max:255",
            "description" => "required|min:15|max:1000",
            "more_infos" => "min:0|max:1000",
            "price" => "required|min:1",
            "brand" => "required",
        ];
    }
}
