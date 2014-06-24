<?php
//define('DOMOB_INSIDE_BASE_DIR', realpath(dirname(__FILE__).'/../../../'));
define('DOMOB_INSIDE_BASE_DIR', $_SERVER['DOCUMENT_ROOT']);
Yii::setPathOfAlias('root', DOMOB_INSIDE_BASE_DIR);
Yii::setPathOfAlias('lib', DOMOB_INSIDE_BASE_DIR.'/lib');
Yii::setPathOfAlias('bootstrap', DOMOB_INSIDE_BASE_DIR.'/lib/bootstrap');
$dbConfig = require_once(DOMOB_INSIDE_BASE_DIR.'/conf/database.conf.php');
$importConfig = require_once(DOMOB_INSIDE_BASE_DIR.'/conf/import.conf.php');
$componentsConfig = require_once(DOMOB_INSIDE_BASE_DIR.'/conf/components.conf.php');
$config = require_once(DOMOB_INSIDE_BASE_DIR.'/conf/config.conf.php');
$app_info= require_once(DOMOB_INSIDE_BASE_DIR.'/cpa/protected/config/appInfo.php');
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
$upload = dirname(__FILE__).DIRECTORY_SEPARATOR.'../upload/';

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Domob',
    'timeZone'=>'Asia/Chongqing',
    'defaultController' => 'home',
    'theme'=>'bootstrap',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>$importConfig['base'],

    'modules'=>array(
	// uncomment the following to enable the Gii tool
	/*
	'gii'=>array(
	    'class'=>'system.gii.GiiModule',
	    'password'=>'zhangli',
	    // If removed, Gii defaults to localhost only. Edit carefully to taste.
	    'ipFilters'=>array('*'),
	),
	*/
    ),

    // application components
    'components'=>array(
	'user'=>$componentsConfig['user'],
	'session'=>$componentsConfig['session'],
	'statePersister' => $componentsConfig['statePersister'],
	'bootstrap'=>array(
	    'class'=>'bootstrap.components.Bootstrap',
	),  
	// uncomment the following to enable URLs in path-format
	/*
	'urlManager'=>array(
	    'urlFormat'=>'path',
	    'rules'=>array(
		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
	    ),
	),
	 */
	'db'=>$dbConfig['cpatool'],
	'mainframeworkDb'=>$dbConfig['mainframework'],
	'errorHandler'=>$componentsConfig['errorHandler'],
	'log'=>$componentsConfig['log'],
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array_merge($config, array('app_info'=>$app_info), array('uploadDir'=>$upload)),
);
