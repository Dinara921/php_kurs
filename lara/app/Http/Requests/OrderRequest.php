<?php

namespace App\Http\Requests;
use App\Models\Order; 
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status' => 'required|integer|between:1,4',  
            'user_id' => 'required|integer', 
            'summa' => 'required|numeric',
        ];
    }
}
