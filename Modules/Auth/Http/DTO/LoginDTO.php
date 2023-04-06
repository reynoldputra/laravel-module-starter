<?php

namespace Modules\Auth\Http\DTO;

use App\Http\Request\ApiRequest;

class LoginDTO extends ApiRequest
{
  public function rules() : array
  {
    return [
        'email' => 'required|email',
        'password' => 'required'
    ];
  }

  public function getEmail() : string {
    return $this->getFieldValue('email'); 
  } 

  public function getPassword() : string {
    return $this->getFieldValue('password'); 
  } 
}
