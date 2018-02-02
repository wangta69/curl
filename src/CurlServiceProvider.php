<?php
namespace Pondol\Curl;

//use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
//use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
//use Route;

class CoinExchangeServiceProvider extends ServiceProvider {

/**
     * Where the route file lives, both inside the package and in the app (if overwritten).
     *
     * @var string
     */
   // public $routeFilePath = '/routes/bbs/base.php';
    
	/**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind('bbs', function($app) {
        //    return new Bbs;
        //});
    }

	/**
     * Bootstrap any application services.
     *
     * @return void
     */
    //public function boot(\Illuminate\Routing\Router $router)
	public function boot()
    {

        /*
         if (!$this->app->routesAreCached()) {
            require_once __DIR__ . '/Https/routes/api.php';
            require_once __DIR__ . '/Https/routes/web.php';
        }
         
         
         // - loadViews  : 상기와 다른 점음  resources/views/bbs 에 없을 경우 아래 것에서 처리한다. for user modify
         // return view('coinexchange::transactions', []); 처럼 사용하면 된다.
         $this->loadViewsFrom(__DIR__.'/resources/views', 'coinexchange');
         */
    }
}
