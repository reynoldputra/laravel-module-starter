<?php

namespace Modules\Auth\Http\DTO;

use Spatie\LaravelData\Data;

class UserDTO extends Data {

    public function __construct(
        public string $user,
        public string $password,
    ) {
    }
    
    // public static function rules(): array
    // {
    //     return [
    //         'user' => ['required', 'string'],
    //         'password' => ['required', 'string'],
    //     ];
    // }
}