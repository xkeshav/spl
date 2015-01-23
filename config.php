<?php
/**
 * A simple, clean and secure PHP Login Script
 *
 * MVC FRAMEWORK VERSION
 * Check GitHub for other versions
 * Check develop branch on GitHub for bleeding edge versions
 *
 * A simple PHP Login Script embedded into a small framework.
 * Uses PHP sessions, the most modern password-hashing and salting
 * and gives all major functions a proper login system needs.
 *
 * @package php-login
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// dev error reporting
error_reporting(E_ALL);
ini_set("display_errors", 1);
ini_set('xdebug.collect_params', '4');
ini_set('xdebug.collect_vars', 'on');
ini_set('xdebug.collect_return', '1');
// var_dump(__DIR__);
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else {
    require_once __DIR__.'/constant.php';
}

spl_autoload_extensions(".php");
spl_autoload_register('loadclass');

function loadclass($class)
{
    try {
        if (is_readable(strtolower($class).".class.php")) {
            include_once strtolower($class).".class.php";
        }
    } catch (Exception $e) {
        print "Exception:". $e;
        trigger_error("Unable to load class: $class", E_USER_WARNING);
    }
}