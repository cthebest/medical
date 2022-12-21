<?php

namespace App\Exceptions;

use Exception;

class UnsoportedActionException extends Exception
{
    public function render($request)
    {
        if ($request->wantsJson()) {
            return response()->json(["error" => true, "message" => $this->getMessage()], 422);
        }

        return $this->getMessage();
    }
}
