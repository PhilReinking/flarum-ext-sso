<?php

namespace Maicol07\SSO\Listener;


use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

class LoadSettingsFromDatabase
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'prepareApiAttributes']);
    }

    public function prepareApiAttributes(Serializing $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            $event->attributes['maicol07-sso.signup_url'] = $this->settings->get('maicol07-sso.signup_url');
            $event->attributes['maicol07-sso.login_url'] = $this->settings->get('maicol07-sso.login_url');
            $event->attributes['maicol07-sso.logout_url'] = $this->settings->get('maicol07-sso.logout_url');
        }
    }
}
