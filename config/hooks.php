<?php

/* --------------------------------------------->
 * Register your hook classes
 * --------------------------------------------->
 *
 * This file: is where you can regiter your class
 * hooks, and make sure the hooks are inside init
 * method in the class.
 *
 */

return [
    \Core\Hooks\Setup::class,
    \Core\Hooks\Route::class,
    \Core\Hooks\Customizer::class,
    \Core\Hooks\Admin::class,
];
