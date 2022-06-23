<?php
namespace Core\Hooks;

class Setup
{
    public function init()
    {
        add_action("after_setup_theme", [$this, "setup"]);
        add_action("wp_enqueue_scripts", [$this, "registerThemeScripts"]);
        add_action("admin_enqueue_scripts", [$this, "registerAdminScripts"]);
        add_action("init", [$this, "posts"]);
        add_action("init", [$this, "taxonomies"]);
    }

    public function registerThemeScripts()
    {
        $scripts = require config("scripts.php");

        if (is_array($scripts) && count($scripts) > 0) {
            foreach ($scripts as $type => $args) {
                if ($type === "style") {
                    wp_enqueue_style(
                        $args["name"],
                        $args["source"],
                        $args["deps"],
                        $args["version"],
                        $args["media"],
                    );
                }

                if ($type === "script") {
                    wp_enqueue_script(
                        $args["name"],
                        $args["source"],
                        $args["deps"],
                        $args["version"],
                        $args["in_footer"],
                    );
                }

                if ($type === "localize_script") {
                    wp_localize_script(
                        $args["handle"],
                        $args["object_name"],
                        $args["data"],
                    );
                }
            }
        }
    }

    public function registerAdminScripts()
    {
        $scripts = require config("scripts.php");
        if (is_array($scripts) && count($scripts) > 0) {
            foreach ($scripts as $type => $args) {
                if ($type === "admin_style") {
                    wp_enqueue_style(
                        $args["name"],
                        $args["source"],
                        $args["deps"],
                        $args["version"],
                        $args["media"],
                    );
                }

                if ($type === "admin_script") {
                    wp_enqueue_script(
                        $args["name"],
                        $args["source"],
                        $args["deps"],
                        $args["version"],
                        $args["in_footer"],
                    );
                }
            }
        }
    }

    public function setup()
    {
        $menus = require get_template_directory() . "/config/menu.php";
        $supports = require get_template_directory() . "/config/supports.php";

        if (is_array($menus) && count($menus) > 0) {
            foreach ($menus as $menu) {
                register_nav_menu($menu["location"], $menu["description"]);
            }
        }

        if (is_array($supports) && count($supports) > 0) {
            foreach ($supports as $support) {
                add_theme_support(
                    $support["feature"],
                    !$support["args"] ? [] : $support["args"],
                );
            }
        }
    }

    public function posts()
    {
        $posts = require config("posts.php");

        if (is_array($posts) && count($posts) > 0) {
            foreach ($posts as $type => $args) {
                register_post_type($type, $args);
            }
        }
    }

    public function taxonomies()
    {
        $taxonomies = require config("taxonomies.php");

        if (is_array($taxonomies) && count($taxonomies) > 0) {
            foreach ($taxonomies as $key => $value) {
                register_taxonomy(
                    $key,
                    $value["object_type"],
                    $value["args"] ?? [],
                );
            }
        }
    }
}
