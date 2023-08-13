<?php

$cmds = array(
    'noargs' => array(
        // Serve the application with default configuration
        'serve' => [ \DEV\Serve::class, 'run' ],
        // Get the routes
        'routes' => [ \DEV\Routes::class, 'list' ],
        // Run tests
        'test' => [ \DEV\Test::class, 'main' ],
        // Run the Main console
        'console' => [ \DEV\Console::class, 'single' ],
        // Create a model recognizer file
        'model-helper' => 'createIdeHelperPlugin',
    ),
    'args' => array(
        // Serve the app to a local development url
        'serve' => [ \DEV\Serve::class, 'customPort' ],
        // Run queries, etc.
        'db' => [ \DEV\Database::class, 'action' ],
        // Use the Development API provided by FlameCore
        'online' => [ \DEV\Online::class, 'connect' ],
        // Create or edit cache
        'cache' => [ \DEV\Cache::class, 'modify' ],
        // Enable production mode
        'production' => [ \DEV\Production::class, 'mode' ],
        // Create a model
        'model' => [ \DEV\Model::class, 'main' ],
        // Create a controller
        'controller' => [ \DEV\Controller::class, 'main' ],
        // Run the console application with a specific class name
        'console' => [ \DEV\Console::class, 'custom' ],
        // Run other projects "ignite" file without locating to that directory
        'cross' => [ \DEV\CrossProject::class, 'main' ],
        'cross.alias' => [ \DEV\CrossProject::class, 'alias' ],
    ),
);

return $cmds;