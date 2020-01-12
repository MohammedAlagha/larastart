<?php

namespace App\Http\Requests\Dashboard;

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
     * @return array
     */
    public function rules()
    {

        switch($this->method())
        {
           case "GET":
           case "DELETE":
                   return [];
               break;

           case "POST":
               return [
                   'name' =>'required|min:4',
                   'email' =>'required|email|unique:users,email',
                   'type' =>'required',
                   'image' =>'image',
                   'password' =>'required|min:8',

               ];
               break;

           case "PUT":
           case "PATCH":
               {
                   $collection = collect($this->request)->toArray();
               return [
                   'first_name' =>'required|min:4',
                   'last_name' =>'required|min:4',
                   'email' => 'required|email|unique:users,email,'.$collection['id'],
                   'image' =>'image',
                   'permissions'          =>'required|min:1',
               ];
           }
           break;
       }

    }
}
