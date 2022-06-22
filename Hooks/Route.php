<?php
namespace Core\Hooks;

use Core\Http\Request;

class Route
{
    public function init()
    {
        add_action("init", [$this, "registerWebRoute"]);
        add_action("rest_api_init", [$this, "registerApiRoute"]);
        add_action("template_include", [$this, "executeWebRoute"]);
    }

    public function registerWebRoute()
    {
        add_rewrite_rule(
            env("WEB_ROUTES_PREFIX") . "/",
            "ndex.php?" . env("WEB_ROUTES_PREFIX") . "=\$matches[0]",
            "top",
        );

        add_filter("query_vars", function ($query_vars) {
            $query_vars[] = env("WEB_ROUTES_PREFIX");
            return $query_vars;
        });
    }

    public function registerApiRoute()
    {
        $routes = require get_template_directory() . "/routes/api.php";

        foreach ($routes as $route) {
            if (!$route["method"]) {
                $route["method"] = \WP_REST_SERVER::READABLE;
            }

            if (is_callable($route["callback"])) {
                register_rest_route(env("REST_ROUTES_PREFIX"), $route["name"], [
                    "methods" => strtoupper($route["method"]),
                    "callback" => $route["callback"],
                ]);
            }

            if (
                !is_callable($route["callback"]) &&
                count($route["callback"]) !== 2
            ) {
                return;
            }

            if (
                is_array($route["callback"]) &&
                count($route["callback"]) === 2
            ) {
                register_rest_route(env("REST_ROUTES_PREFIX"), $route["name"], [
                    "methods" => strtoupper($route["method"]),
                    "callback" => [
                        new $route["callback"][0](),
                        $route["callback"][1],
                    ],
                ]);
            }
        }
    }

    public function executeWebRoute($template)
    {
        if (
            get_query_var(env("WEB_ROUTES_PREFIX")) == false ||
            get_query_var(env("WEB_ROUTES_PREFIX")) == ""
        ) {
            return $template;
        }

        return get_template_directory() . "/vendor/worvel/core/config/routing.php";
    }

    public function filterRoutes()
    {
        $routes = require get_template_directory() . "/routes/web.php";

        if(is_array($routes) && count($routes) > 0)
        {
            foreach ($routes as $route) {
                $name = "/" . env("WEB_ROUTES_PREFIX") . $route["name"];

                if (!$route["method"]) {
                    $route["method"] = "GET";
                }

                if (
                    strtolower(Request::get()->route()->method) ===
                        strtolower($route["method"]) &&
                    strtolower(Request::get()->route()->current) ===
                        strtolower($name)
                ) {
                    status_header(200);
                    echo $this->callback($route["callback"]);
                    return;
                }
            }
        }

        if (file_exists(get_template_directory() . "/404.php")) {
            require get_template_directory() . "/404.php";
            return;
        } else {
            echo "<h1 style='text-align: center'>404</h1>";
            return;
        }
    }

    private function callback($callback)
    {
        if (is_callable($callback)) {
            return $callback();
        }
        if (!is_array($callback) && count($callback) !== 2) {
            return;
        }

        $callback_class = $callback[0];
        $callback_method = $callback[1];

        $callback_instance = new $callback_class();
        echo $callback_instance->$callback_method();
        return;
    }
}
