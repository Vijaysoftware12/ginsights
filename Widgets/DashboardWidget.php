<?php
namespace Analytics\Gaddon\Widgets;
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
    public function html(){
        $filePathre = __DIR__;
        $refresh_token="";
        $notauthorized = "false";


            $rootPath = base_path();

            //  $filePathre = '../../content/refresh_token.yaml';
            //  echo "<a href=".$filePathre.">asdf</a>";
            $filePathre = str_replace(
                "Widgets",
                "/src/content/refresh_token.yaml",
                $filePathre
            );

            $yamlString = file_get_contents($filePathre);

            // Parse the YAML string to retrieve the data
            $datare = Yaml::parse($yamlString);
            //dd($datare);
            // Access the refresh token from the data array
                
           
                $refresh_token = $datare["refresh_token"];
//dd($refresh_token);
                $property_id = "";
                $filePath =
                    $rootPath .
                    "/vendor/ginsights/gaddon/src/content/webproperty.yaml";
    
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
                    "/vendor/ginsights/gaddon/src/content/webproperty.yaml";
    
                $yamlString = file_get_contents($filePath);
    
                // Parse the YAML string to retrieve the data
                $data = Yaml::parse($yamlString);
                // Access the refresh token from the data array
                //dd('72');
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

            /*    //For local testing
                   $response = Http::post('http://vijaystatamic.com/apipost', [
                    'refresh_token' =>  $refresh_token,
                     'property_id' => $property_id
                ]);*/

           /*     $response = Http::post('http://statamic.vijaysoftware.com/public/apipost', [
                    'refresh_token' =>  $refresh_token,
                     'property_id' => $property_id
                ]);
               // dd($response->body());
               

                if($response->successful()==false )
                {       
                  
                    $notauthorized=true;
                
                    return view("gaddon::widgets.gadashboard")
                    ->with("notauthorized", $notauthorized); 
                }
                else
                {         
                 
                    $notauthorized=false; 
                    $data=($response->object());  
                // dd($data);                             
                   $totalsessions=$data[0]->sessions;
                   $totalpgviews=$data[0]->totalpgviews;
                   $totalusers=$data[0]->users;
                   $prvssessions=$data[0]->prvssessions;
                   $totalusersPrvs=$data[0]->prvsusers;
                    $totalpgviewsPrvs=$data[0]->prvspgviews;
                    $daterange=$data[0]->daterange;
                    $prvsdaterange=$data[0]->prvsdaterange;
                   $sessionPercent=$data[0]->sessionPercent;
                   $pgviewsPercent=$data[0]->pgviewsPercent;
                   $totalusersPercent=$data[0]->totalusersPercent;
                   $newusers=$data[0]->newUsers;
                   $newusersPercent=$data[0]->newusersPercent;
                   $averageSessionDuration=$data[0]->averageSessionDuration;
                   $bounceRate=$data[0]->bounceRate;
                   $graphsessions=$data[0]->graphsessions;
                   $graphpageviews=$data[0]->graphpageviews;
                  
      
              return view("gaddon::widgets.gadashboard")
                ->with("totalsessions", $totalsessions)
                ->with("totalpgviews", $totalpgviews)
                ->with("totalusers", $totalusers)
                ->with("prvssessions",$prvssessions)
                ->with("prvsusers",$totalusersPrvs)
                ->with("prvspgviews",$totalpgviewsPrvs)
                ->with("property_id", $property_id)            
               ->with("daterange",$daterange)            
                ->with("prvsdaterange",$prvsdaterange)
                ->with("sessionPercent",$sessionPercent) 
                ->with('pgviewsPercent',$pgviewsPercent)
                ->with('totalusersPercent',$totalusersPercent)
                ->with('newUsers',$newusers) 
                ->with( 'newusersPercent',$newusersPercent)              
                ->with('averageSessionDuration',$averageSessionDuration)  
                ->with('bounceRate',$bounceRate)  
                ->with('graphsessions',$graphsessions)  
                ->with('graphpageviews',$graphpageviews) 
                ->with("notauthorized", $notauthorized);  
             return view("gaddon::widgets.gadashboard")
           ->with("property_id", $property_id)
            ->with("refresh_token", $refresh_token)
            ->with("notauthorized", $notauthorized);                     
    
                }*/
                //dd($refresh_token);
               /* if(isset($refresh_token) && isset($property_id))
                {
                $notauthorized="false";
                }
                else{
                    $notauthorized="true";
                }*/


                //dd( $notauthorized);
              //  $notauthorized="false";
                
                return view("gaddon::widgets.gadashboard")
                ->with("property_id", $property_id)
                 ->with("refresh_token", $refresh_token)
                 ->with("notauthorized", $notauthorized); 
                 
             }
    
    }   

}

?>
