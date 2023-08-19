<?php

if(!function_exists('framework_debugger_generated_id')) {
     function framework_debugger_generated_id() {
          if(!isset($GLOBALS['fdgid___'])) $GLOBALS['fdgid___'] = uniqid('fgid:');
          return $GLOBALS['fdgid___'];
     }
}

if(!function_exists('jsvarwcolor')) {
     function jsvarwcolor($data, $color = true, callable|null $callback = NULL, $json = false) {
          if(!$json) $var = var_export($data, true);
          else $var = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
          if($color) $var = highlightText($var);
          if(is_callable($callback)) $var = $callback($var);
          return ($var);
     }
}

?>
<div debug_console_application="button:@framework_debugger_generated_id()" class="transition duration-150 cursor-pointer fixed bottom-0 right-0 p-2 bg-gray-900 hover:bg-gray-950 shadow flex items-center rounded-tl border-2 border-r-0 border-b-0 z-[999]">
     <div class="flex items-center">
          {{ FlameView()->import('./utils/logo.html') }}
     </div>
</div>
<div 
debug_console_application="app:@framework_debugger_generated_id()" 
class="hidden fixed bottom-0 left-0 w-full bg-gray-900 resizable z-[99999] drop-shadow">
     <div class="resizer box-border border-t-4 border-[#ffca3a] w-full cursor-n-resize"></div>
     <div debugger_tabs class="flex border-b overflow-x-scroll">
          <div class="transition duration-150 flex items-center cursor-pointer text-3xl px-4 pt-4 pb-1 hover:bg-gray-950 border-r">
               @svglogo
          </div>
          <div class="bg-gray-900 p-5 w-full"></div>
     </div>
     <div debugger_pages class="w-4/5 mx-auto !max-h-full overflow-y-scroll my-auto">

     </div>
</div>
<div class="hidden h-full text-2xl !bg-gray-950"></div>
<div ___tailwind_used_classes class="p-2 my-2 hidden text-3xl text-2xl text-xl my-2 my-3 border-r border-l py-5 bg-yellow-300 text-gray-900 px-2 py-0.5 rounded mx-1 pt-5 pb-14 text-lg font-bold"></div>
@script()
{
     {{ FlameView()->import('./js/app.js') }}
}
@script()

#flame-engine.ignore:start
<style>
.___debug_code_block {
     border-radius: 0;
     border-bottom-right-radius: 0px;
     border-bottom-right-radius: 3px;
     font-size: 18px;
     padding: 15px;
     background-color: #262335;
     width: 100%;
     overflow-y: scroll;
     border-radius: 3px;
     width: 100%;
     display: block;
     max-height: 300px;
     overflow: scroll;
}
[debugger__tab_selected] {
     background-color: rgb(3 7 18 / var(--tw-bg-opacity)) !important;
}
</style>
#flame-engine.ignore:end