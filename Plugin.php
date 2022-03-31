<?php namespace VojtaSvoboda\Ecomail;

use Backend;
use System\Classes\PluginBase;
use VojtaSvoboda\Ecomail\Components\Subscribe;
use VojtaSvoboda\Ecomail\Models\Settings;

/**
 * Ecomail Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            Subscribe::class => 'ecomail_subscribe',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'vojtasvoboda.ecomail.configure' => [
                'tab' => 'Ecomail',
                'label' => 'Configure Ecomail API credentials.',
            ],
        ];
    }

    /**
     * Registers backend settings model.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Ecomail',
                'icon' => 'icon-envelope',
                'description' => 'Configure Ecomail API access.',
                'class' => Settings::class,
                'order' => 600,
                'permissions' => [
                    'vojtasvoboda.ecomail.configure',
                ],
            ]
        ];
    }
}
