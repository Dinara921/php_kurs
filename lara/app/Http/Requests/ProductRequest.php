<?php

namespace App\Http\Requests;
use App\Models\Product; 
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'nullable|string|min:5', 
            'category_id' => 'required|integer', 
            'country_id' => 'nullable|integer', 
            'img' => 'nullable|string', 
            'sale_id' => 'nullable|integer',  
            'count' => 'required|integer', 
            'price' => 'required|integer'
        ];
    }
}
