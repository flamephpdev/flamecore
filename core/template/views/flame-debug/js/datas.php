<?php

$data = [
     'appId' => framework_debugger_generated_id(),
     'attribute' => 'debug_console_application',
     'tabs' => [
          'Route' => [
               ['title' => 'Current Path'],
               ['miniCodeBlock' => urlPath() ],
               ['title' => 'Route Name (or id)'],
               ['miniCodeBlock' => routeName(true) ? jsvarwcolor(routeName(true)) : jsvarwcolor("index") ],
          ],
          'Request' => [
               ['title' => 'Method'],
               ['miniCodeBlock' => strtoupper(request()->method()) ],
               ['title' => 'Request raw data'],
               ['miniCodeBlock' => jsvarwcolor(request()->rawData()) ],
               ['title' => 'Query Params'],
               ['miniCodeBlock' => jsvarwcolor($_GET) ],
          ],
          'Performance' => [
               ['title' => 'Render time'],
               ['miniCodeBlock' => highlightText(getrtime() . " s") ],
               ['title' => 'Memory usage'],
               ['miniCodeBlock' => highlightText(formatBytes(memusage())) ],
          ],
          'View' => [
               ['title' => 'Root view'],
               ['miniCodeBlock' => jsvarwcolor($GLOBALS["views_data__info"][0]['file']), 'dropdown' => jsvarwcolor($GLOBALS["views_data__info"][0]['data'], json: true) ],
               ['title' => 'Component tree'],
               [
                    'miniCodeBlock' => 
                    jsvarwcolor(
                         array_column($GLOBALS["views_data__info"], 'file'), 
                         callback: fn($d) => 
                              str_replace(
                                   '.src/:', 
                                   '<span class="bg-yellow-300 text-gray-900 px-2 py-0.5 rounded mx-1">#templates/</span>', 
                                   $d
                              )
                    ) 
               ],
          ]
     ]
];

if(class_exists('DB')) {
     $data['tabs']['Database'][]['title'] = 'Querys';
     foreach(DB::get_all_querys() as $log) {
          //dd($log);
          $data['tabs']['Database'][] = [
               'miniCodeBlock' => jsvarwcolor($log->query),
               'dropdown' => "<h4 class='text-lg font-bold bg-yellow-300 text-gray-900 px-2 py-0.5 rounded w-min'>Bindings:</h4>" . jsvarwcolor($log->binded_data) .
               "\n<h4 class='bg-yellow-300 text-gray-900 px-2 py-0.5 rounded w-min'>File:</h4>" . jsvarwcolor(str_replace(path(ROOT), '', path($log->called['file']))) . ":" . jsvarwcolor($log->called['line']) .
               "\n<h4 class='bg-yellow-300 text-gray-900 px-2 py-0.5 rounded w-min'>Class:</h4>" . highlightText($log->called['class'] . "::class") .
               "\n<h4 class='bg-yellow-300 text-gray-900 px-2 py-0.5 rounded w-min'>Function:</h4>" . jsvarwcolor($log->called['function'])
          ];    
     }
}

if(class_exists('DB') && _env('USE_AUTH')) {
     $user = user();
     $data['tabs']['Auth'] = [
          [ 'title' => 'Current user' ],
          ['miniCodeBlock' => jsvarwcolor($user ? $user->fields : false, json: true) ],
          [ 'title' => 'User Model' ],
          [ 
               'miniCodeBlock' => highlightText(($user ? get_class($user) : 'Core\App\Accounts\User') . "::class"),
               'dropdown' => jsvarwcolor(config('user'))
          ],
     ];
}

if(_env('USE_SESSION')) {
     $data['tabs']['Session'] = [
          [ 'title' => 'Session data' ],
          ['miniCodeBlock' => jsvarwcolor(session(), json: true) ],
          [ 'title' => 'Cookies' ],
          ['miniCodeBlock' => jsvarwcolor($_COOKIE, json: true) ],
     ];
}

echo base64_encode(json_encode($data));