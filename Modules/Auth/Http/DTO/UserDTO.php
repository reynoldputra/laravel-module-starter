<?php

namespace Modules\Auth\Http\DTO;

use App\Http\Request\ApiRequest;

class UserDTO extends ApiRequest {
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'name' => 'required'
        ];
    }
    
    public function getEmail() : string {
      return $this->getFieldValue('email');
    }

    public function getPassword() : string {
      return $this->getFieldValue('password');
    }

    public function getName() : string {
      return $this->getFieldValue('name');
    }
}
