<?php

namespace App\Http\Requests;
use App\Models\OrderDetail; 
use Illuminate\Foundation\Http\FormRequest;

class OrderDetailRequest extends FormRequest
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
            'products_id' => 'required|integer'  
            'count' => 'required|integer', 
            'order_id' => 'required|integer',
            'price' => 'required|integer'
        ];
    }
}
