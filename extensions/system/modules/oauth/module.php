<?php

use Pagekit\OAuth\Helper\OAuthHelper;

return [

    'name' => 'system/oauth',

    'main' => function ($app) {

        $app['oauth'] = function () {
            return new OAuthHelper;
        };

        $app->on('system.tmpl', function ($event) {
            $event->register('settings.oauth', 'extensions/system/modules/oauth/views/tmpl/settings.razr');
        });

        $app->on('system.settings.edit', function ($event) use ($app) {
            $app['view']->script('oauth-settings', 'extensions/system/modules/oauth/assets/js/settings.js', 'vue-system');

            $event->options($this->name, $this->config);
            $event->view($this->name, __('OAuth'), $app['tmpl']->render('extensions/system/modules/oauth/views/admin/settings.php'));
            $event->data('oauth', $app['oauth']->getProvider());
            $event->data('redirect_url', $app['oauth']->getRedirectUrl());
        });
    },

    'autoload' => [

        'Pagekit\\OAuth\\' => 'src'

    ],

    'controllers' => [

        '@system: /' => [
            'Pagekit\\OAuth\\Controller\\OAuthController'
        ]

    ],

    'config' => [
        'provider' => [],
    ]

];
