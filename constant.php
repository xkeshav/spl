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
define('PTOTOCOL','http://');
// This will gives folder name of project if this file (config.php is on right place in directory structure inside one folder
define('PROJECT_FOLDER', basename(dirname(__DIR__))); // ==> 'eonfx'
// d(PROJECT_FOLDER);
// echo "<pre>";print_r($_SERVER);
// define('PROJECT_FOLDER', 'eonfx');
// d($_SERVER);
/**
 * Configuration for: Base URL
 * This is the base url of our app. if you go live with your app, put your full domain name here.
 * if you are using a (differen) port, then put this in here, like http://mydomain:8888/mvc/
 * TODO: when not using subfolder, is the trailing slash important ?
 */
define('HOST', PTOTOCOL.$_SERVER['HTTP_HOST']); // ==> 'http://192.168.0.228'
define('PROJECT_ROOT', $_SERVER['DOCUMENT_ROOT'].PROJECT_FOLDER);  // ==> '/opt/lampp/htdocs/eonfx'
define('URL', HOST.DS.PROJECT_FOLDER); // ==> 'http://192.168.0.228/eonfx
// d(PROJECT);
// physical location where we store all project images and thumbnails
/**
 * Configuration for: Folders
 * Here you define where your folders are. Unless you have renamed them, there's no need to change this.
 */
// don't forget to make this folder writeable via chmod 775
// the slash at the end is VERY important!

define('LIBS', PROJECT_ROOT.DS.'libs'.DS);
// define('LIBS', 'libs'.DS); /* TODO : also works with this line in localhost.! */
define('CSSPATH', URL.'/public/css');
define('JSPATH', URL.'/public/js');
define('IMAGEPATH', URL.'/public/images');
define('AVATAR_PATH', URL.'/public/avatars'.DS);
define('LOGOPATH', URL.'/data/client_logos'.DS);


/**
 * Archive Folder..outside of apache root
 **/
define('ARCHIVE', './data/archive_links/');


