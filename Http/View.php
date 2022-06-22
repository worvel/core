<?php

namespace Core\Http;

class View
{
    private static $directory;

    /* --------------------------------------------->
     * View file includer
     * --------------------------------------------->
     *
     * This method includes the view file from the dir
     * passed as a parameter to the first argument as
     * a string..
     *
     * @param string $dir: file name in the views dir
     * @param Array $variables: data to pass in view.
     * @return
     *
     */

    public static function make(string $dir, $variables = [])
    {
        extract($variables);

        self::$directory = str_replace(".", "/", $dir);

        require get_template_directory() .
            "/resources/views/" .
            self::$directory .
            ".php";

        return;
    }
}
