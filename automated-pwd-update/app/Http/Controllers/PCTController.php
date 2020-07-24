<?php

namespace App\Http\Controllers;

use App\Models\PCT;
use Illuminate\Http\Request;

class PCTController extends Controller
{
    
    public $pct;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pct=new PCT();
    }

    public function change_password(Request $request)
    {        
        return $this->pct->change_password($request);
    }


    //
}
