<?php

namespace Vijaysoftware\Ginsights;

use Statamic\Providers\AddonServiceProvider;
use Illuminate\Support\Facades\Route;
use Statamic\Facades\Utility;
use Illuminate\Routing\Router;
use Statamic\Facades\Statamic;
use Vijaysoftware\Ginsights\Tags\Ginsightsgtag;

class ServiceProvider extends AddonServiceProvider
{

    protected $scripts = [
        __DIR__.'/../resources/js/jquery-3.6.0.min.js',  
        __DIR__.'/../resources/js/jquery-ui.js',
        __DIR__.'/../resources/js/all.min.js',
        __DIR__.'/../resources/js/Chart.js',
        __DIR__.'/../resources/js/daterangepicker.min.js',
        __DIR__.'/../resources/js/html2pdf.bundle.min.js',
        __DIR__.'/../resources/js/jquery.dataTables.min.js',     
        __DIR__.'/../resources/js/moment.min.js',
        __DIR__.'/../resources/js/Customjs.js'
  
      ];
      protected $stylesheets = [
          __DIR__.'/../resources/css/jquery-ui.css',
          __DIR__.'/../resources/css/daterangepicker.css',
          __DIR__.'/../resources/css/font-awesome.min.css',
          __DIR__.'/../resources/css/jquery.dataTables.min.css',
          __DIR__.'/../resources/css/all.min.css'      
  
      ];
      protected $widgets = [
         Widgets\DashboardWidget::class,
      ]; 
  
      protected $tags = [
         //\GInsights\Gaddon\Tags\Gatag::class,
         \Vijaysoftware\Ginsights\Tags\Ginsightsgtag::class,
          
      ];
   
     protected $routes = [
        'web' => __DIR__.'/../routes/web.php',
    ];

    public function bootAddon()
    {
		if ($this->app->runningInConsole()) {
            $this->setDirectoryOwnership();
        }
		
        $this->bootVendorAssets();

        Utility::extend(function () {
            $filePathre = __DIR__;
             
            $svgContent='<svg xmlns=http://www.w3.org/2000/svg viewBox="0 0 29.04 30.01">
                <g id="Layer_2" data-name="Layer 2">
                <g id="Layer_1-2" data-name="Layer 1">
                <polygon id="CAD_Rectangle" fill="#fff" data-name="CAD Rectangle" class="cls-1" points="29.03 22.78 17.03 30.01 12 30.01 0.06 23.12 0.18 9.86 0.51 6.28 28.52 6.27 29.04 9.96 29.03 22.78"/>
                <g>
                <path class="cls-2" fill="#0067a7" d="M12,.83A6.33,6.33,0,0,1,14.36,0a4.54,4.54,0,0,1,2.3.62c3.72,1.75,7.46,3.46,11.19,5.2a2.73,2.73,0,0,1,.68.44c.09.31-.26.45-.46.6-1.71.93-3.48,1.75-5.18,2.69a4.2,4.2,0,0,0-1.34,1.5q-3.35,5.7-6.82,11.31l-.33.07a7.35,7.35,0,0,1-.89-1.33c-1.76-2.92-3.54-5.82-5.26-8.76a7.35,7.35,0,0,0-2.2-2.84c-1.64-.9-3.33-1.7-5-2.58-.23-.17-.64-.3-.56-.66a2.86,2.86,0,0,1,.78-.49C4.85,4.14,8.39,2.48,12,.83Z"/>
            
                <path class="cls-3" fill= "#6d6e71" d="M0,11.12A2.71,2.71,0,0,1,.18,9.86a5.42,5.42,0,0,1,.66.91q5.27,8.91,10.56,17.8A2.87,2.87,0,0,1,12,30a6.09,6.09,0,0,1-1.36-.53q-4.52-2.1-9-4.18A2.6,2.6,0,0,1,.13,23.76a14.61,14.61,0,0,1-.09-3C0,17.52,0,14.32,0,11.12Z"/>
            
                <path class="cls-3" fill= "#6d6e71" d="M28.37,10.49c.16-.23.3-.53.62-.52.09,4.27,0,8.54,0,12.81a2.47,2.47,0,0,1-1.38,2.41c-3,1.43-6.1,2.81-9.14,4.24A7.84,7.84,0,0,1,17,30a4.77,4.77,0,0,1,.91-1.93Q23.15,19.28,28.37,10.49Z"/>
                </g>
                </g>
                </g>
                </svg>'; //file_get_contents($filePathre.'/content/vijay-icon.svg');
               
                Utility::register('Analytics')
                ->title(__('GInsights Analytics'))
                ->icon($svgContent)
                ->description(__('Manage and view google analytics data.'))	
                ->routes(function (Router $router) {				
                    $router->get('/', [AnalyticsController::class, 'index'])->name('show'); 
                    $router->post('/', [AnalyticsController::class, 'index'])->name('view'); 
                   // $router->post('/', [AnalyticsController::class, 'cacheconversion'])->name('view');    
//$router->post('/cacheconversion', [ConversionController::class, 'index'])->name('sview');   
                    
                })                               	
                ->view('gaddon::analytics'); //blank view	
            });
    }
    protected function bootVendorAssets()
    {       
		$this->publishes([
			__DIR__.'/../resources/css/images' => public_path('vendor/ginsights/css/images'),
			], 'ginsights');
		
		$this->publishes([
			__DIR__.'/../resources/images' => public_path('vendor/ginsights/images'),
			], 'ginsights');

		$this->publishes([
		  __DIR__.'/../resources/webfonts' => public_path('vendor/ginsights/webfonts'),
			], 'ginsights');

		return $this;
    }  
	
	protected function setDirectoryOwnership()
    {
        $directory = base_path();
        
        // Get existing owner
        $ownerUid = fileowner($directory);
        $ownerInfo = posix_getpwuid($ownerUid);
        $owner = $ownerInfo['name'];

        $contentdir="vendor/vijaysoftware/ginsights/src/content";
        echo "Existing owner of the directory is: {$owner}\n";

       // $owner = 'www-data'; // Example owner

        if (file_exists($contentdir)) {
            $this->changeOwnership($contentdir, $owner);
            echo "Ownership set to {$owner} for directory and its contents: {$contentdir}\n";
            $this->changePermissions($contentdir);
            echo "Permissions set to 775 for directory and its contents: {$contentdir}\n";
        } else {
            echo "Directory does not exist: {$contentdir}\n";
        }
    }
	protected function changeOwnership($path, $owner)
    {
        if (is_dir($path)) {
            $items = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($items as $item) {
                chown($item, $owner);
            }
        }
        // Finally, change ownership of the directory itself
        chown($path, $owner);
    }
    /*protected function changePermissions($path)
    {
    try {
        if (is_dir($path)) {
            $items = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($items as $item) {
                chmod($item, 0775); // ugo+rw equivalent
            }
        }
        chmod($path, 0775); // ugo+rw equivalent
    } catch (\Exception $e) {
        echo "Failed to set permissions for path {$path}: " . $e->getMessage() . "\n";
    }
}*/
protected function changePermissions($path)
{
    try {
        if (is_dir($path)) {
            $items = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($items as $item) {
                if ($item->isDir()) {
                    chmod($item, 0775); // Directories need execute permissions
                } elseif ($item->isFile()) {
                    chmod($item, 0664); // Files typically do not need execute permissions
                }
            }
        }
        chmod($path, 0775); // Final chmod for the root directory
    } catch (\Exception $e) {
        echo "Failed to set permissions for path {$path}: " . $e->getMessage() . "\n";
    }
}


}
