<?php

namespace Heroku\Component\Database;

use Composer\Script\Event;

class HerokuDatabase
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

        $io = $event->getIO();

        $io->write('DATABASE_URL='.getenv('DATABASE_URL'));
    }
}

