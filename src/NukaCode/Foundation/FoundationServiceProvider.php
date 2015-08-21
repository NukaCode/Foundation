<?php namespace NukaCode\Foundation;

use NukaCode\Core\BaseServiceProvider;

class FoundationServiceProvider extends BaseServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $namespace = 'nukacode/front-end';

    const NAME = 'foundation';

    const VERSION = '1.0.6';

    const DOCS = 'front-end-foundation';

    public function boot()
    {
        $this->loadConfigsFrom(__DIR__ . '/../../config', $this->namespace);
        $this->loadAliasesFrom(config_path($this->namespace), $this->namespace);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->shareWithApp();
        $this->registerViews();
    }

    /**
     * Share the package with application
     *
     * @return void
     */
    protected function shareWithApp()
    {
        $this->app['foundation'] = $this->app->share(function ($app) {
            return true;
        });
    }

    /**
     * Register views
     *
     * @return void
     */
    protected function registerViews()
    {
        $this->app['view']->addLocation(__DIR__ . '/../../views');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['foundation'];
    }
}
