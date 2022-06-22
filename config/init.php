<?php

/* --------------------------------------------->
 * Execute the registered hooks
 * --------------------------------------------->
 *
 * This file:: executes all the hooks inside init
 * method, and you dont need to add or change any
 * thing from this file.
 *
 */

$hooks = require_once get_template_directory() .
    "/vendor/worvel/core/config/hooks.php";
$customHooks = require_once get_template_directory() . "/config/hooks.php";

if (is_array($hooks) && count($hooks)) {
    foreach ($hooks as $hook) {
        $setup = new $hook();
        $setup->init();
    }
}

if (is_array($customHooks) && count($customHooks)) {
    foreach ($customHooks as $hook) {
        $setup = new $hook();
        $setup->init();
    }
}
