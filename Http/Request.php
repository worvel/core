<?php

namespace Core\Http;

use Core\Http\Route;

class Request
{
    private $home = "/";
    private $current;
    private $method;
    private $vars = [];

    public function route()
    {
        $home = end(explode("/", home_url()));
        $path = explode("?", $_SERVER["REQUEST_URI"]);
        $this->method = $_SERVER["REQUEST_METHOD"];

        $uri = explode($home, $path[0])[1];
        $vars = $path[1];

        if ($uri) {
            $this->current = $uri;
            $last_key = substr($uri, -1);

            if ($last_key === "/") {
                $this->current = substr($uri, 0, -1);
            }
        }

        if (!$this->current) {
            $this->current = "/";
        }

        if ($vars) {
            $separate_vars = explode("&", $vars);

            if (count($separate_vars) > 0) {
                foreach ($separate_vars as $var) {
                    $key = explode("=", $var)[0];
                    $value = explode("=", $var)[1];
                    $this->vars[$key] = $value;
                }
            }
        }

        if ($home) {
            $this->home = "/" . $home;
        }

        if ($this->formRequestMethod() !== null) {
            $this->method = $this->formRequestMethod();
        }

        $request = new \stdClass();
        $request->home = $this->home;
        $request->current = $this->current;
        $request->vars = $this->vars;
        $request->method = $this->method;

        return $request;
    }

    private function formRequestMethod()
    {
        $allowedMethods = ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"];
        $formMethod = null;

        if (isset($_POST["_method"])) {
            if (in_array(strtoupper($_POST["_method"]), $allowedMethods)) {
                $formMethod = strtoupper($_POST["_method"]);
            }
        }

        return $formMethod;
    }

    public static function get()
    {
        return new Request();
    }
}
