<?php

namespace GInsights\Gaddon;

use Illuminate\Support\Facades\Route;
use Statamic\Facades\Utility;
use Illuminate\Routing\Router;
use Statamic\Providers\AddonServiceProvider;
 
//use Statamic\Extend\Widget;

use Statamic\Facades\Statamic;
use GInsights\Gaddon\Tags\Gatag;


class ServiceProvider extends AddonServiceProvider
{
   /*  protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    */
 //  protected $viewNamespace = 'gaddon';
   
 /* protected $widgets = [
        Widgets\CustomWidget::class,
    ];*/
    

protected $widgets = [
    Widgets\DashboardWidget::class,
    ];

    protected $tags = [
        \GInsights\Gaddon\Tags\Gatag::class,
    ];
 /*   widget content to add in cp.php
    [
            'type' => 'dashboardwidget',                
            'limit' => 5,
        ],
        [ 
            'type' => 'gijo_widget',
            'width' => 100,
        ]    

        */
   /* protected $tags = [
        Tags\Gatag::class,
    ];     */  

    public function bootAddon()
    {         
      //  view()->addNamespace('analytics', resource_path('views'));
      //  $this->registerWidgets();
       // $this->app['view']->composer('partials.admin.index', function ($view) {
         //   $view->with('hello', 'hello');
      //  });  
     // Statamic::widget('dashboardwidget', Analytics\Gaddon\Widgets\DashboardWidget::class);
    
   //  $this->loadViewsFrom(__DIR__ . '/resources/views', 'gaddon');
     //Widget::register('dashboardwidget',DashboardWidget::class);
  
     

            Utility::extend(function () {
                Utility::register('Analytics')
                ->title(__('Analytics'))
                ->icon('book-pages')
                ->description(__('Manage and view google analytics data.'))	
                ->routes(function (Router $router) {				
                    $router->get('/', [AnalyticsController::class, 'index'])->name('show'); 
                    $router->post('/', [AnalyticsController::class, 'index'])->name('view');
                   // $router->get('/api', [ApiController::class, 'html'])->name('api'); 
                    //$router->post('/dp', [AnalyticsController::class, 'dp'])->name('dp');
                 //   $router->post('/dp', [AnalyticsController::class, 'dpproperty'])->name('dpp');                 
                }) 
                              	
                ->view('gaddon::analytics'); //blank view	
            });
  

           
      //  $this->registerWidgets();
     //  Widget::register(DashboardWidget::class);
           		
    } 
    
    
}
