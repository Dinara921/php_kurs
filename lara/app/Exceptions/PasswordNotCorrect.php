<?php

namespace App\Exceptions;

use Exception;

class PasswordNotCorrect extends Exception
{
    public function render($request)
    {
        return response()->json(['error' => 'User not found.'], 404);
    }
}
