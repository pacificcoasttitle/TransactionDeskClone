<?php

namespace App\Traits;

//Under Development

trait Auth
{
    public function loggedInUser()
    {
        auth()->user();
    }
}
