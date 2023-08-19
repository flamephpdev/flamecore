<?php

// use the 3 most important classes
use Core\Framework\Framework;
use Core\App\Request;
use Core\App\Response;

// define the application start time
define('START_TIME', microtime(true));

define('F_MEM_USAGE',memory_get_usage());

// require the initializer tools and the whole app
require __DIR__ . '/../core/initialize.php';
// load the framework
Framework::load('web')->then(function(){
    // when the framework loaded
    // catch the requested data
    Request::catch();
    // load all routes and make a response by controllers
    // and views
    Response::make();
});