<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
  public function getAllFields() : array 
  {
    return $this->all();
  }
  
  public function getFieldValue(string $key) : mixed
  {
    return $this->input($key);
  }  
    
  public function getAllQueries() : array | string | null 
  {
    return $this->query();
  }

  public function getQuery(string $key) : array | string | null
  {
    return $this->query($key);
  }  
}
