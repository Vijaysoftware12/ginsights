<?php
namespace Vijaysoftware\Ginsights\Tags;

use Statamic\Tags\Tags;
use Symfony\Component\Yaml\Yaml;

class Ginsightsgtag extends Tags
{
    /**
     * The {{ ginsightsgtag }} tag.
     *
     * @return string|array
     */
    public function index()
    {
         $currentDir = __DIR__;
		$filePath = dirname(__DIR__) . '/content/gtag.yaml';
		$yamlString = file_get_contents($filePath);
      
        // Parse the YAML string to retrieve the data
        $config = Yaml::parse($yamlString);
        if($config){
            $measurement_id =$config['gtag_id'];
		}
       
?>
 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        
        // Set your measurement ID dynamically
        var measurementidd = '<?php echo $measurement_id; ?>';

        // Include gtag.js script
        var gtagScript = document.createElement('script');
        gtagScript.async = true;
        gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=' + measurementidd;
        document.head.appendChild(gtagScript);
        //console.log(gtagScript.src );
        // gtag.js configuration
        gtagScript.onload = function() {
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', measurementidd);
        };
        console.log(measurementidd);
    });
</script>
<?php
    }    
}
?>
