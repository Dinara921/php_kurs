<?php

namespace App\Http\Requests;
use App\Models\Review; 
use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return 
        [
            'product_id' => 'required|integer', 
            'user_id' => 'required|integer', 
            'text' => 'required|string:max:1000', 
            'grade' => 'required|integer|between:1,5'
        ];
    }
}
