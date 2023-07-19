<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsulCalcController extends Controller
{
    public function calculate(Request $request){
        $length = $request->input('length');
        $width = $request->input('width');
        $height = $request->input('height');
        $rValue = $request->input('rValue');

        $volume = $length * $width * $height / $rValue;

        return $volume;
    }
}
