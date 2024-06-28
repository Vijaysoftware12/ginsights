<?php

namespace Vijaysoftware\Ginsights\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConversionController extends Controller
{
    public function index(Request $request)
    {
        $data=$request['rData'];
        $interval=$request['interval'];
        $interval=$interval;
        $propertyid = $request['property_id'];

        Cache::put('dpviewdata'.$interval.$propertyid, $data, $seconds = 20000);
       
        return response()->json(['message' => $data]);

    }
}
