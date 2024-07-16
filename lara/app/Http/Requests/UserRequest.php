<?php

namespace App\Http\Requests;
use App\Models\User; 
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
             'email' => 'required|string|email|unique:users,email',
             'password' => 'required|string|min:8|max:20', 
             'name' => 'nullable|string', 
             'address' => 'required|string|max:255',  
             'phone' => 'nullable|numeric'  
        ]; 
    }
}
