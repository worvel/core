<?php

namespace Core\Hooks;

class Admin
{
    public function init()
    {
        add_action("admin_menu", [$this, "registerAdminMenu"]);
    }

    public function registerAdminMenu()
    {
        $adminPages = require get_template_directory() . "/config/admin.php";

        if (is_array($adminPages) && count($adminPages) > 0) {
            foreach ($adminPages as $adminPage) {
                if ($adminPage["level"] === "top") {
                    add_menu_page(
                        $adminPage["page_title"],
                        $adminPage["menu_title"],
                        $adminPage["capability"],
                        $adminPage["menu_slug"],
                        is_array($adminPage["callback"])
                            ? [
                                new $adminPage["callback"][0](),
                                $adminPage["callback"][1],
                            ]
                            : $adminPage["callback"],
                        $adminPage["icon"],
                        $adminPage["position"],
                    );
                }

                if ($adminPage["level"] === "sub") {
                    add_submenu_page(
                        $adminPage["parent_slug"],
                        $adminPage["page_title"],
                        $adminPage["menu_title"],
                        $adminPage["capability"],
                        $adminPage["menu_slug"],
                        is_array($adminPage["callback"])
                            ? [
                                new $adminPage["callback"][0](),
                                $adminPage["callback"][1],
                            ]
                            : $adminPage["callback"],
                        $adminPage["position"],
                    );
                }
            }
        }
    }
}
