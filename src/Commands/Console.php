<?php

namespace Core\Commands;

class Console
{
    public static function init($argv)
    {
        $commandTag = $argv[1];
        unset($argv[0], $argv[1]);
        $flags = array_values($argv);

        $consoles = require_once get_template_directory() .
            "/vendor/worvel/core/config/console.php";
        $customConsoles = require_once get_template_directory() .
            "/config/console.php";

        if (is_array($consoles) && count($consoles) > 0) {
            foreach ($consoles as $command) {
                $command = new $command();

                if ($commandTag === $command->tag) {
                    $command->handle($flags);
                    return;
                }
            }
        }

        if (is_array($customConsoles) && count($customConsoles) > 0) {
            foreach ($customConsoles as $command) {
                $command = new $command();

                if ($commandTag === $command->tag) {
                    $command->handle($flags);
                    return;
                }
            }
        }
    }
}
