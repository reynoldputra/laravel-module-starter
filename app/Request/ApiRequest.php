<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    public function getInputData()
    {
        return $this->all();
    }
}