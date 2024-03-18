<?php
namespace GInsights\Gaddon\Widgets;
use Symfony\Component\Yaml\Yaml;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Statamic\Facades\File;
use Illuminate\Http\Client\ConnectionException;

use Statamic\Widgets\Widget;
//use Statamic\Providers\AddonServiceProvider;

use Illuminate\Support\Facades\Cache;

class DashboardWidget extends Widget
{
    public function html()
    {
        // No additional data needed for this simple example

        // echo 'Hello world';
        $filePathre = __DIR__;
        $notauthorized = false;

   
            $rootPath = base_path();

            //  $filePathre = '../../content/refresh_token.yaml';
            //  echo "<a href=".$filePathre.">asdf</a>";
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
                $filePath =
                    $rootPath .
                    "/addons/GInsights/gaddon/src/content/webproperty.yaml";
    
                $yamlString = file_get_contents($filePath);
    
                // Parse the YAML string to retrieve the data
                $data = Yaml::parse($yamlString);
                // Access the refresh token from the data array
    
                if ($data) {
                    $property_id = $data["property_id"];
                }
                $current_time = time();
         

                $property_id = "";
                $filePath =
                    $rootPath .
                    "/addons/GInsights/gaddon/src/content/webproperty.yaml";
    
                $yamlString = file_get_contents($filePath);
    
                // Parse the YAML string to retrieve the data
                $data = Yaml::parse($yamlString);
                // Access the refresh token from the data array
    
                if ($data) {
                    $property_id = $data["property_id"];
    
                    // Set the property_id variable to the cached value.
                    //$property_id1 = 'properties/360664735';
    
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

                                            
                  
                   return view("gaddon::widgets.gadashboard")
                   ->with("property_id", $property_id)
                    ->with("refresh_token", $refresh_token)
                    ->with("notauthorized", $notauthorized); 
    
                
            }
    }

}

?>
