<?php

namespace Core\Hooks;

class Admin
{
    public function init()
    {
        add_action("admin_menu", [$this, "registerAdminSidebarMenu"]);
        add_action("admin_bar_menu", [$this, "registerAdminbarMenu"], 500);
    }

    public function registerAdminSidebarMenu()
    {
        $adminPages = require get_template_directory() . "/config/admin.php";
        $sidebarMenus = $adminPages["sidebar"];

        if (is_array($sidebarMenus) && count($sidebarMenus) > 0) {
            foreach ($sidebarMenus as $sidebarMenu) {
                if ($sidebarMenu["level"] === "top") {
                    add_menu_page(
                        $sidebarMenu["page_title"],
                        $sidebarMenu["menu_title"],
                        $sidebarMenu["capability"],
                        $sidebarMenu["menu_slug"],
                        is_array($sidebarMenu["callback"])
                            ? [
                                new $sidebarMenu["callback"][0](),
                                $sidebarMenu["callback"][1],
                            ]
                            : $sidebarMenu["callback"],
                        $sidebarMenu["icon"],
                        $sidebarMenu["position"],
                    );
                }

                if ($sidebarMenu["level"] === "sub") {
                    add_submenu_page(
                        $sidebarMenu["parent_slug"],
                        $sidebarMenu["page_title"],
                        $sidebarMenu["menu_title"],
                        $sidebarMenu["capability"],
                        $sidebarMenu["menu_slug"],
                        is_array($sidebarMenu["callback"])
                            ? [
                                new $sidebarMenu["callback"][0](),
                                $sidebarMenu["callback"][1],
                            ]
                            : $sidebarMenu["callback"],
                        $sidebarMenu["position"],
                    );
                }
            }
        }
    }

    public function registerAdminbarMenu(\WP_Admin_Bar $adminbar)
    {
        $adminPages = require get_template_directory() . "/config/admin.php";
        $adminbarMenus = $adminPages["adminbar"];

        if (is_array($adminbarMenus) && count($adminbarMenus) > 0) {
            foreach ($adminbarMenus as $adminbarMenu) {
                $adminbar->add_menu($adminbarMenu);
            }
        }
    }
}
