<?php namespace NukaCode\Foundation\Html;

use NukaCode\Html\HtmlServiceProvider as BaseHtmlServiceProvider;

class HtmlServiceProvider extends BaseHtmlServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHtmlBuilder();

        $this->registerFormBuilder();

		$this->registerBBCode();
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->bindShared('foundation-html', function($app)
        {
            return $app->make('NukaCode\Foundation\Html\HtmlBuilder');
        });
    }

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->bindShared('foundation-form', function($app)
        {
            $form = new FormBuilder($app['foundation-html'], $app['url'], $app['session.store']->getToken(), $app['view']);

            return $form->setSessionStore($app['session.store']);
        });
    }

}