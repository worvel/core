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
        $sources = require config("scripts.php");

        if (is_array($sources) && count($sources) > 0) {
            $styles = $sources["styles"];
            $scripts = $sources["scripts"];
            $localize_scripts = $sources["localize_scripts"];

            if (is_array($styles) && count($styles) > 0) {
                foreach ($styles as $style) {
                    wp_enqueue_style(
                        $style["name"],
                        $style["source"],
                        $style["deps"],
                        $style["version"],
                        $style["media"],
                    );
                }
            }

            if (is_array($scripts) && count($scripts) > 0) {
                foreach ($scripts as $script) {
                    wp_enqueue_script(
                        $script["name"],
                        $script["source"],
                        $script["deps"],
                        $script["version"],
                        $script["in_footer"],
                    );
                }
            }

            if (is_array($localize_scripts) && count($localize_scripts) > 0) {
                foreach ($localize_scripts as $localize_script) {
                    wp_localize_script(
                        $localize_script["handle"],
                        $localize_script["object_name"],
                        $localize_script["data"],
                    );
                }
            }
        }
    }

    public function registerAdminScripts()
    {
        $sources = require config("scripts.php");

        if (is_array($sources) && count($sources) > 0) {
            $styles = $sources["admin_styles"];
            $scripts = $sources["admin_scripts"];

            if (is_array($styles) && count($styles) > 0) {
                foreach ($styles as $style) {
                    wp_enqueue_style(
                        $style["name"],
                        $style["source"],
                        $style["deps"],
                        $style["version"],
                        $style["media"],
                    );
                }
            }

            if (is_array($scripts) && count($scripts) > 0) {
                foreach ($scripts as $script) {
                    wp_enqueue_script(
                        $script["name"],
                        $script["source"],
                        $script["deps"],
                        $script["version"],
                        $script["in_footer"],
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
