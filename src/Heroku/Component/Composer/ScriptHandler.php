<?php


namespace Heroku\Component\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    public static function populateEnvironment(Event $event)
    {
        $url = getenv('DATABASE_URL');

        if ($url) {
            $url = parse_url($url);
            putenv('DATABASE_HOST=' . $url['host']);
            putenv('DATABASE_USER=' . $url['user']);
            putenv('DATABASE_PASSWORD=' . $url['pass']);
            putenv('DATABASE_NAME=' . substr($url['path'], 1));
        }

        $event->getIO()->write('Set database environment variables');
    }

    public static function createWebspace(Event $event)
    {
        $file = 'app/Resources/webspaces/sulucloud.xml';

        $webspaceConfig = file_get_contents($file . '.dist');

        // replace URL
        $webspaceConfig = str_replace(
            'sulucloud.herokuapp.com',
            getenv('DOMAIN'),
            $webspaceConfig
        );

        file_put_contents($file, $webspaceConfig);

        $event->getIO()->write('Created webspace config file');
    }
}

