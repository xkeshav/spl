<?php
/**
 *
 * THIS IS THE CONFIGURATION FILE
 *
 * For more info about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 * @file config.php
 *
 * @copyright  Dotsquares Technologies , Dec 10,2014
 * @package  strictly with PHP 5.3 +
 * @author Keshav Mohta
 * @todo  all constant on different page
 * @access  private
 * @category  configuration
 * @deprecated
 * @
 * @example  This if first file of project which check and make sure to work project
 *
 *
 */

require __DIR__.'/kint/Kint.class.php';
define('DS', DIRECTORY_SEPARATOR);
define('PROTOCOL', $_SERVER['REQUEST_SCHEME'].':'.DS.DS); // http://
// This will gives folder name of project if this file (config.php is on right place in directory structure inside one folder
define('PROJECT_FOLDER', basename(__DIR__)); // ==> 'spl'
// echo "<pre>";print_r($_SERVER);
// define('PROJECT_FOLDER', 'eonfx');
// d($_SERVER);
/**
 * Configuration for: Base URL
 * This is the base url of our app. if you go live with your app, put your full domain name here.
 * if you are using a (differen) port, then put this in here, like http://mydomain:8888/mvc/
 * TODO: when not using subfolder, is the trailing slash important ?
 */
define('HOST', $_SERVER['HTTP_HOST']); // ==> '192.168.0.228'
define('URL', PROTOCOL.HOST.DS.PROJECT_FOLDER);  //'http://192.168.0.228/eonfx'
define('PATH', $_SERVER['DOCUMENT_ROOT'].PROJECT_FOLDER);  // ==> '/opt/lampp/htdocs/spl'
// physical location where we store all project images and thumbnails
/**
 * Configuration for: Folders
 * Here you define where your folders are. Unless you have renamed them, there's no need to change this.
 */
define('CSS', URL.DS.'css');
define('JS', URL.DS.'js');
define('IMG', URL.DS.'images');
define('ARCHIVE', dirname($_SERVER['DOCUMENT_ROOT']).'/archive');