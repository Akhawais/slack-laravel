<?php

namespace Maknz\Slack\Laravel;

use Maknz\Slack\Client as Client;
use GuzzleHttp\Client as Guzzle;

class ServiceProviderLaravel5 extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/config/config.php' => config_path('slack.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'slack');

        $this->app['maknz.slack'] = new Client(
                $this->app['config']->get('slack.endpoint'),
                [
                    'channel' => $this->app['config']->get('slack.channel'),
                    'username' => $this->app['config']->get('slack.username'),
                    'icon' => $this->app['config']->get('slack.icon'),
                    'link_names' => $this->app['config']->get('slack.link_names'),
                    'unfurl_links' => $this->app['config']->get('slack.unfurl_links'),
                    'unfurl_media' => $this->app['config']->get('slack.unfurl_media'),
                    'allow_markdown' => $this->app['config']->get('slack.allow_markdown'),
                    'markdown_in_attachments' => $this->app['config']->get('slack.markdown_in_attachments'),
                ],
                new Guzzle
            );
    
        $this->app->bind('Maknz\Slack\Client', 'maknz.slack');
    }
}
