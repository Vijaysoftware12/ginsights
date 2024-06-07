<?php

namespace Vijaysoftware\Ginsights\Widgets;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Statamic\Facades\File;
use Illuminate\Http\Client\ConnectionException;
use Statamic\Widgets\Widget;
use Illuminate\Support\Facades\Cache;

class DashboardWidget extends Widget
{
    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {
        $filePathre = __DIR__;
        //dd( $filePathre );
        $refresh_token="";
        $notauthorized = "false";
        $rootPath = base_path();           
        $filePathre = str_replace(
                "Widgets",
                "/content/refresh_token.yaml",
                $filePathre
        );
        $yamlString = file_get_contents($filePathre);
        // Parse the YAML string to retrieve the data
        $datare = Yaml::parse($yamlString);
        // Access the refresh token from the data array  
        $refresh_token = $datare["refresh_token"];
        $property_id = "";
        $filePath = $rootPath .
            "/addons/vijaysoftware/ginsights/src/content/webproperty.yaml";
    
        $yamlString = file_get_contents($filePath);        
        $data = Yaml::parse($yamlString);
            if ($data) {
                $property_id = $data["property_id"];
            }
        $current_time = time();
        $property_id = "";
        $filePath = $rootPath . 
            "/addons/vijaysoftware/ginsights/src/content/webproperty.yaml";
    
        $yamlString = file_get_contents($filePath);
        // Parse the YAML string to retrieve the data
        $data = Yaml::parse($yamlString);
        // Access the refresh token from the data array
            if ($data) {
                $property_id = $data["property_id"];    
                // Set the property_id variable to the cached value.                   
    
                $totalsessions = 0;
                $totalusers = 0;
                $totalpgviews = 0;
                $prvssessions=0;
                $totalusersPrvs=0;
                $totalpgviewsPrvs=0;
                $percent=0;
                $sessionPercent=0; 
                $pgviewsPercent=0;
                $newusers="";
                $averageSessionDuration="";
                $bounceRate="";
                $totalusersPercent=0;
                $graphsessions="";
                $graphpageviews="";
                $newusersPercent="";
                $daterange="";
                $prvsdaterange="";
                
                return view("ginsights::widgets.gadashboard")
					->with("property_id", $property_id)
					->with("refresh_token", $refresh_token)
					->with("notauthorized", $notauthorized);                
            }    
    }
}
