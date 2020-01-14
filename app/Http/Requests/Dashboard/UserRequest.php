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

        switch ($this->method()) {
            case "GET":
            case "DELETE":
                return [];
                break;

            case "POST":
                return [
                    'name' => 'required|min:4',
                    'email' => 'required|string|max:191|email|unique:users,email',
                    'type' => 'required',
                    'image' => 'image',
                    'password' => 'required|min:8',

                ];
                break;

            case "PUT":
            case "PATCH": {
                    $collection = collect($this->request)->toArray();
                    return [
                        'name' => 'required|min:4',
                        'email' => 'required|string|email|max:191|unique:users,email,' . $collection['id'],
                        'type' => 'required',
                        'image' => 'image',
                        'password' => 'sometimes|required|min:8',
                    ];
                }
                break;
        }
    }
}
