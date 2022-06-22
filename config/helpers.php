<?php

/* --------------------------------------------->
 * Assets folder directory url
 * --------------------------------------------->
 *
 * This function is a simple version of wordpress
 * get_template_directory_uri() that can only get
 * access in assets dir.
 *
 * @param String: file name inside the assets dir
 * @return String: the url of the file.
 *
 */
function asset($path = "")
{
    return get_template_directory_uri() . "/resources/assets/" . $path;
}

/* --------------------------------------------->
 * Config folder directory
 * --------------------------------------------->
 *
 * This function is a simple version of wordpress
 * get_template_directory, that can get access in
 * config folder only.
 *
 * @param String: file name inside the config dir
 * @return String: the dir of the file.
 *
 */
function config($path = "")
{
    return get_template_directory() . "/config\/" . $path;
}

/* --------------------------------------------->
 * Style file includer
 * --------------------------------------------->
 *
 * This function is a simple version of wordpress
 * wp_enqueue_style() function, and it also takes
 * all it's parameters.
 *
 * @return Array of the style args
 *
 */
function style($name, $source, $deps = [], $version = null, $media = "all")
{
    return [
        "name" => $name,
        "source" => $source,
        "deps" => $deps,
        "version" => $version,
        "media" => $media,
    ];
}

/* --------------------------------------------->
 * Script file includer
 * --------------------------------------------->
 *
 * This function is a simple version of wordpress
 * wp_enqueue_script() function and it also takes
 * all it's parameters.
 *
 * @return Array of the script args
 *
 */
function script($name, $source, $deps = [], $version = null, $in_footer = false)
{
    return [
        "name" => $name,
        "source" => $source,
        "deps" => $deps,
        "version" => $version,
        "in_footer" => $in_footer,
    ];
}

/* --------------------------------------------->
 * Localize script includer
 * --------------------------------------------->
 *
 * This function is a simple version of wordpress
 * wp_localize_script function, and it also takes
 * all it's parameters.
 *
 * @return Array of the localize_script() args.
 *
 */
function localize_script($handle, $object_name, $data)
{
    return [
        "handle" => $handle,
        "object_name" => $object_name,
        "data" => $data,
    ];
}

/* --------------------------------------------->
 * View file includer
 * --------------------------------------------->
 *
 * This function is a simple version of the class
 * \Core\Http\View, and executes the make method
 * that includes the view file.
 *
 * @param string $dir: file name in the views dir
 * @param Array $variables: data to pass in view.
 * @return View::make().
 *
 */
function view($dir, $variables = [])
{
    return \Core\Http\View::make($dir, $variables);
}

/* --------------------------------------------->
 * Env File key getter
 * --------------------------------------------->
 *
 * This function is a simple version of the class
 * \Core\Http\Config, and executes the env method
 * that returns the value of of the $key.
 *
 * @param string $key: array key
 * @return Config::get()->env().
 *
 */
function env($key)
{
    return \Core\Http\Config::get()->env($key);
}

/* --------------------------------------------->
 * Env File key getter
 * --------------------------------------------->
 *
 * This function is a simple version of the class
 * \Core\Http\Config, and executes the route method
 * that returns full url.
 *
 * @param string $id: array key
 * @param string $type: web or api default is api
 * @return Config::get()->route().
 *
 */
function route($id, $type = "web")
{
    return \Core\Http\Config::get()->route($id, $type);
}

/* --------------------------------------------->
 * Component Includer
 * --------------------------------------------->
 *
 * This function is a simple version of the class
 * \Core\Http\Config, and executes the component
 * method that includes the component file.
 *
 * @param string $name: component name
 * @param array $data: the data will be passed
 * @return Config::get()->component().
 *
 */
function component($name, $data = [])
{
    return \Core\Http\Config::get()->component($name, $data);
}
