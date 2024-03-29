<?php

return array(
    // the folder where the dev views stored
    'view-folder' => ROOT . '/views',

    // ez tags for easier writing, usage: {{ asset('css/main.css') }} // returns the main css url
    'ez-tags' => array(
        0 => '{{',
        1 => '}}',
        2 => '*', // use this to disable echo in php
        3 => '!', // use this for auto htmlspecialchars function
        4 => '--', // use this for comments
    ),

    'view-render-file-ext' => '.flame.{ext}', // file extension to render

    'replace-tags-to' => array(
        '@else:' => 'else:',
        '@CSRF' => 'echo \Core\App\Security\Csrf::tokenInput()',
        '@dev' => 'if(_env(\'APP_DEV\')):',
        '@enddev' => 'endif',
        '@debugger' => 'view(".src/:helpers/debugger")',
        '@svglogo' => 'echo "<svg version=\"1.1\" viewBox=\"0 0 32 32\" xml:space=\"preserve\" xmlns=\"http://www.w3.org/2000/svg\" enable-background=\"new 0 0 32 32\"><path d=\"M27 4H5C3.3 4 2 5.3 2 7v18c0 1.7 1.3 3 3 3h2.8c-.5-1-.8-2-.8-3.1-.1-2.7.7-5.3 2.5-7.5l.3-.4c.8-1 1.6-2 2-3 .2-.6.7-1.1 1.2-1.5 1.2-.8 2.9-.6 3.9.4 1.5 1.6 2.4 3.3 2.7 5 0 .2.1.4.1.6.5-.3 1.1-.5 1.7-.5 1.1 0 2.1.7 2.6 1.7.9 1.9 1.2 4.3.8 6.4-.1.6-.4 1.3-.6 1.8H27c1.7 0 3-1.3 3-3V7c0-1.7-1.3-3-3-3zM7.9 8.4c0 .1-.1.2-.2.3-.2.2-.4.3-.7.3s-.5-.1-.7-.3C6.1 8.5 6 8.3 6 8c0-.3.1-.5.3-.7l.1-.1c.1 0 .1-.1.2-.1.1-.1.1-.1.2-.1h.4c.1 0 .1 0 .2.1.1 0 .1.1.2.1l.1.1c.1.1.2.2.2.3.1.1.1.3.1.4 0 .1 0 .3-.1.4zm2.8.3c-.2.2-.4.3-.7.3-.3 0-.5-.1-.7-.3-.2-.2-.3-.4-.3-.7 0-.1 0-.3.1-.4.1-.1.1-.2.2-.3.1-.1.2-.2.3-.2.4-.2.8-.1 1.1.2.1.1.2.2.2.3.1.1.1.3.1.4 0 .3-.1.5-.3.7zm3.2-.3c-.1.1-.1.2-.2.3-.2.2-.4.3-.7.3-.1 0-.3 0-.4-.1-.1-.1-.2-.1-.3-.2-.1-.1-.2-.2-.2-.3-.1-.1-.1-.3-.1-.4 0-.1 0-.3.1-.4.1-.1.1-.2.2-.3.4-.4 1-.4 1.4 0 .1.1.2.2.2.3.1.1.1.3.1.4 0 .1 0 .3-.1.4z\" fill=\"#ff595E\" class=\"fill-000000\"></path><path d=\"M22.2 20.7c-.2-.3-.5-.5-.9-.6-.4 0-.7.2-.9.5l-.1.2c0 .1-.1.2-.1.2-.5.7-1.1 1.1-2.1 1.2H18v-.7c-.1-1.1-.1-2.1-.3-3.2-.3-1.4-1-2.7-2.2-4-.3-.3-.9-.4-1.3-.1-.2.1-.4.3-.5.5-.5 1.3-1.3 2.3-2.3 3.5l-.3.4c-1.5 1.9-2.2 4-2.1 6.2.1 3.3 3.3 6.2 6.9 6.2 3.3 0 6.2-2.2 6.9-5.3.4-1.6.2-3.5-.6-5z\" fill=\"#ffca3a\" class=\"fill-000000\"></path></svg>"',
    ),

);