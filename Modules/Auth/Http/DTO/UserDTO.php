<?php

namespace Modules\Auth\Http\DTO;

use App\Request\ApiRequest;

class UserDTO extends ApiRequest {

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required'
        ];
    }

}