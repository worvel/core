<?php

namespace Core\Http;

class Config
{
    public static function get()
    {
        return new Config();
    }

    public function env($key)
    {
        return $this->filterEnv($key);
    }

    public function route($id, $type = "web")
    {
        if ($type === "web") {
            $webRoutes = require get_template_directory() . "/routes/web.php";

            foreach ($webRoutes as $route) {
                if ($route["id"] === $id) {
                    $routeUrl =
                        site_url() .
                        "/" .
                        env("WEB_ROUTES_PREFIX") .
                        $route["name"];
                    return $routeUrl;
                }
            }

            return 0;
        }

        if ($type === "api") {
            $apiRoutes = require get_template_directory() . "/routes/api.php";

            foreach ($apiRoutes as $route) {
                if ($route["id"] === $id) {
                    $routeUrl =
                        site_url() .
                        "/" .
                        env("WEB_ROUTES_PREFIX") .
                        $route["name"];
                    return $routeUrl;
                }
            }

            return 0;
        }

        return 0;
    }

    public function component($name, $data = [])
    {
        if (is_array($data)) {
            extract($data);
        }

        $name = str_replace(".", "/", $name);

        require get_template_directory() .
            "/resources/views/components/" .
            $name .
            ".php";
    }

    private function filterEnv($key)
    {
        $env = require get_template_directory() . "/config/env.php";

        return $env[$key];
    }
}
