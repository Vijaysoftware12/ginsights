<?php

namespace GInsights\Gaddon;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Statamic\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Statamic\Facades\File;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AnalyticsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
   public function getRefreshToken()

   {

            $filePathre = __DIR__;
            $notauthorized = false;
            $rootPath = base_path();
           
            $filePathre=$filePathre.'/content/refresh_token.yaml';
            $yamlString = file_get_contents($filePathre);

            // Parse the YAML string to retrieve the data
            $datare = Yaml::parse($yamlString);

            // Access the refresh token from the data array             
                $refresh_token = $datare["refresh_token"];
                return($refresh_token);

   }
   public function rtokenValidate(){

    $refresh_token=$this->getRefreshToken();
          
    $response = Http::post('https://statamic.vijaysoftware.com/public/validate', [
         'refresh_token' =>  $refresh_token
        
     ]);

    return $response->body();

   }
  
    public function reauth(){
       
            $refresh_token=$this->getRefreshToken();
            
         
            if($this->rtokenValidate()=='valid'){
           
              $response = Http::post('https://statamic.vijaysoftware.com/public/reauth', [
                'refresh_token' =>  $refresh_token,
                'returnUrl' => env('APP_URL')
                
            ]);     
    
            $authUrl=$response->body();          
            header("Location: $authUrl");
            exit;
            }
            else 
            {
                $response = Http::post('https://statamic.vijaysoftware.com/public/init', [
                   
                    'returnUrl' => env('APP_URL')
                    
                ]);                         
                $authUrl=$response->body();               
                header("Location: $authUrl");
                exit;    
            }
    }
    public function switchUser(Request $request){

        if($request['reauth']=='true'){       
            $refresh_token=$this->getRefreshToken();            
            $response = Http::post('https://statamic.vijaysoftware.com/public/validate', [
                'refresh_token' =>  $refresh_token               
            ]);
   
            if($this->rtokenValidate()=='valid'){
           
              $response = Http::post('https://statamic.vijaysoftware.com/public/reauth', [
                'refresh_token' =>  $refresh_token,
                'returnUrl' => env('APP_URL')
                
            ]);
              
            $authUrl=$response->body();          
            header("Location: $authUrl");
            exit;
            }    
        }
    }

    public function index(Request $request )
    {          
        if($request['reauth']=='true'){       
        $this->reauth();
     }
     if(!isset($_GET['refresh_token_new'])){
       if($this->rtokenValidate()=='not valid'){?>
            <script>
                //alert("Please authorize your account");
            </script>
            <?php    
            return view('gaddon::redirect');   
        }
    }
        
    //default value   
    $startDate=date('Y-m-d', strtotime('-7 days'));
    $endDate=date('Y-m-d', strtotime('-1 days'));      

    if(isset($_REQUEST['dp1'])){    
        $startDate=$_REQUEST['dp1'];
        $endDate=$_REQUEST['dp2'];    
    }
  
    if($request['period']){   
        $interval = $request['period'];     
    }
    else
    {
        $interval=7; //default       
    }
  
        if(isset($_GET['refresh_token_new'])){
            $rtokennew=$_GET['refresh_token_new'];
                                    
                $filePath = __DIR__ . '/content/refresh_token.yaml';
                $datare = [
                    'refresh_token' => $rtokennew,
                ];
                          
                    $yamlString = Yaml::dump($datare); 
                    $permissions = 0755;
                    File::put($filePath, $yamlString);
                 
                    $refresh_token = $datare['refresh_token'];
                    //call process token                
                    $response = Http::post('https://statamic.vijaysoftware.com/public/processtoken', [
                        'refresh_token' =>  $refresh_token
                       
                    ]);

                    $this->newIds = $response->body();
                    $this->newIds= json_decode($this->newIds, true);
                    if(empty($this->newIds)){ 
                        
                        return view('gaddon::no_viewid'); 
                    }
                    else{
                     
                    return view('gaddon::select_viewid')
                    ->with('newIds',$this->newIds);  
                    }
                 
        }
       
       if($request['reset'] == 'true')
        {            
        return view('gaddon::settingsview');      
        }     
        
        switch ($request['period']) {           
           
            case "custom":                 
                $startDate = date('Y-m-d',strtotime($request["dp1"]));
                $endDate = date('Y-m-d',strtotime($request["dp2"]));
     
                  // Store the values in the session
                if(isset($startDate) && isset($endDate)){
                    Session::put('startDate', $startDate);
                    Session::put('endDate', $endDate);
                    $sDate = new \DateTime($startDate);
                    $eDate = new \DateTime($endDate);
                    // Adjust end date to include the selected day
                    $eDate->modify('+1 day');

                    $difference = date_diff($sDate, $eDate);
                    
                    // Access the days from the DateInterval object
                    $interval= $difference->days;
                    $property_id=$request['selectedid'];
                    $data= $this->getGAData($interval,$startDate,$endDate);
                   
                    return view('gaddon::dpview')
                    ->with('data',$data)
                    ->with('startDate', $startDate)
                    ->with('endDate', $endDate)
                    ->with('interval',$interval)
                    ->with('selectedid',$property_id);
                    
                  }
         
              break;
            default:          
                           
         
          }  
           
                
        $selectid = null;
    //View generating after authorizing and selecting viewids and then displaying detailed report 
        if($request['selectedid'])
        {          
            $filePath = __DIR__ . '/content/webproperty.yaml';
            $yamlString = file_get_contents($filePath);
            $property_yaml['property_id']=$request['selectedid'];
            $yamlstring = Yaml::dump($property_yaml);
            File::put($filePath, $yamlstring);           
           $refresh_token=$this->getStoredRefreshToken();        
          $response = Http::post('https://statamic.vijaysoftware.com/public/dpviewnew', [
               'refresh_token' =>  $refresh_token,
               'property_id' => $request['selectedid'],
               'interval'=>$interval,             
               'startDate'=> $startDate,
             'endDate'=>$endDate                       
           ]);
        
           $data=$response->body();

            $this->store($request);    
            return view('gaddon::dpview')
            ->with('data',$data)
            ->with('startDate', $startDate)
            ->with('endDate', $endDate)
            ->with('interval',$interval);
         
        }
        else
        {
         $property_id=0;
        }

     // View generating from Utilities->Analytics->Detailed Report page 
       if(isset($request['selectedid']))
       {  
  
        $property_id = $request['selectedid'];        
        if($request['dp1']){           
           $startDate=date('Y-m-d',strtotime($request['dp1']));
           $endDate=date('Y-m-d',strtotime($request['dp2']));
         
        }
        else{
            $startDate=date('Y-m-d', strtotime('-7 days'));
            $endDate=date('Y-m-d', strtotime('-1 days'));
        }               
       }
       else
       {     
            $startDate=date('Y-m-d', strtotime('-7 days'));
            $endDate=date('Y-m-d', strtotime('-1 days'));
            $interval = 7;                      
            $data= $this->getGAData($interval,$startDate,$endDate);
         
             return view('gaddon::dpview')
             ->with('data',$data)
             ->with('startDate', $startDate)
             ->with('endDate', $endDate)
             ->with('interval',$interval)
             ->with('selectedid',$property_id);
              
       }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getGAData($interval,$startDate,$endDate)
    {
        $refresh_token=$this->getStoredRefreshToken();

             $rootPath = base_path();
             $property_id = "";
             $filePath =
                 $rootPath ."/vendor/ginsights/gaddon/src/content/webproperty.yaml";
 
             $yamlString = file_get_contents($filePath);            
             $data = Yaml::parse($yamlString);
                         
             if ($data) {
                 $property_id = $data["property_id"];}
 
        $response = Http::post('https://statamic.vijaysoftware.com/public/dpviewnew', [
            'refresh_token' =>  $refresh_token,
            'property_id' => $property_id,
            'interval'=>$interval,         
            'startDate'=> $startDate,
          'endDate'=>$endDate                       
        ]); 
     return $response->body();

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gtag_id = $request->input('gtag_id');
       
        // Store the GTM ID in a YAML file.
        $filePath = __DIR__ . '/content/gtag.yaml';
        $gtag_yaml = file_get_contents($filePath);
       
        $yaml_data['gtag_id'] = $gtag_id;

        $yaml = Yaml::dump($yaml_data);
        File::put($filePath, $yaml);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {          
     
    }
   
    public function getStoredRefreshToken()
    {
        $filePath = __DIR__ . '/content/refresh_token.yaml';
        $yamlString = file_get_contents($filePath);
      
        // Parse the YAML string to retrieve the data
        $data = Yaml::parse($yamlString);
        // Access the refresh token from the data array
        if($data){
        $refresh_token = $data['refresh_token'];       
        return $refresh_token;
        }

    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function validRefreshToken($refresh_token,$client)
    {
      
        $client->fetchAccessTokenWithRefreshToken($refresh_token);
        if ($client->getAccessToken()) {
            //"Refresh token is valid.";          
        
            return true;
        } else {
            echo 'invalid refresh token';
        
            return false;
        }
    }

}  

