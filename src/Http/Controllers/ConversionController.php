<?php

namespace Vijaysoftware\Ginsights\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Yaml\Yaml;
use Statamic\Facades\File;

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
    public function disconnect(){
        $rootPath = base_path();
        $filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/refresh_token.yaml';
        
        $datare = [
                'refresh_token' => 'disconnected',
        ];
        $yamlString = Yaml::dump($datare);            
        File::put($filePath, $yamlString);
        $filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/webproperty.yaml';
        
        $datare = [
                'property_id' => ' ',
        ];
        $yamlString = Yaml::dump($datare);            
        File::put($filePath, $yamlString);
        $filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/gtag.yaml';
        
        $datare = [
                'gtag_id' => ' ',
        ];
        $yamlString = Yaml::dump($datare);            
        File::put($filePath, $yamlString);
        $filePath = $rootPath . '/vendor/vijaysoftware/ginsights/src/content/activeprofile_gtag.yaml';
        
        $datare = [
                'gtag_id' => ' ',
        ];
        $yamlString = Yaml::dump($datare);            
        File::put($filePath, $yamlString);
         
        return view('ginsights::redirect');
        
        
        }

        
}
