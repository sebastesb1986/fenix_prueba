<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = ( ($this->getMethod() === 'PUT') ? $this->id : null);
        $password = ( ($this->getMethod() === 'PUT') ? 'nullable|min:6' : 'required|min:6');
        
        // Obtener el user_id para el metodo actualizar y evitar conflictos al momento de actualizar datos
        $user_id = $this->user()->profile->user_id;


        return [

            'username' => 'required', 
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => $password,
            'name' => 'required', 
            'lastname' => 'required', 
            'address' => 'required', 
            'phone' => 'required',
            'gender' => 'required', 
            
        ];
    }

    public function attributes()
    {
        return [

            'username' => 'Nombre de usuario', 
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'name' => 'Nombre(s)', 
            'lastname' => 'Apellido(s)', 
            'address' => 'Dirección', 
            'phone' => 'Teléfono', 
            'gender' => 'Genero', 
             
        ];
    }

    public function messages()
    {
      
        return [

            'username.required' => 'Digite Nombre de usuario', 
            'email.required' => 'Digite correo electrónico',
            'email.unique' => 'El correo electrónico ya se encuentra registrado',
            'email.email' => 'Correo electrónico no valido',
            'password.required' => 'Digite Contraseña',
            // 'password.confirmed' => 'Confirmar Contraseña',
            'name.required' => 'Digite Nombre(s)', 
            'lastname.required' => 'Digite Apellido(s)', 
            'address.required' => 'Digite Dirección', 
            'phone.required' => 'Digite Teléfono', 
            'gender.required' => 'Seleccione Genero', 

  
        ];
    }

    public function failedValidation(Validator $validator) { 
        // Pasamos en json los errores del request
       throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422)); 
   }
}
