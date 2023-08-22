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
<!-- {{ str_repeat("-", 50) }} -->
<!-- ATTENTION! ONLY USE IT ON DEVELOPMENT! -->
<!--
     FlameCore Debugger Console for client-side web apps
     Framework version: v{{ VERSION }}
     Application Built on OpenFramework: https://github.com/bndrmrtn/openframework/
     Debugger Console Version: ALPHA
-->
<!-- HTML App Code -->
<div debug_console_application_wrapper_element flamephp_window_debugger_tailwindcss_root_element><div debug_console_application="button:@framework_debugger_generated_id()" class="fldb-transition fldb-duration-150 fldb-cursor-pointer fldb-fixed fldb-bottom-0 fldb-right-0 fldb-p-2 fldb-bg-gray-900 hover:fldb-bg-gray-950 fldb-shadow fldb-flex fldb-items-center fldb-rounded-tl fldb-border-2 fldb-border-r-0 fldb-border-b-0 fldb-border-sweetred fldb-z-[999]"><div class="fldb-flex fldb-items-center">{{ $_VIEW->import('./utils/logo.html') }}</div></div><div debug_console_application="app:@framework_debugger_generated_id()" class="fldb-text-white fldb-hidden fldb-fixed fldb-bottom-0 fldb-left-0 fldb-w-full fldb-bg-gray-900 fldb-resizable fldb-z-[99999] fldb-drop-shadow"><div class="resizer fldb-box-border fldb-border-t-4 fldb-border-sunglow fldb-w-full fldb-cursor-n-resize"></div><div debugger_tabs class="fldb-flex fldb-border-b fldb-overflow-x-scroll"><div class="fldb-transition fldb-duration-150 fldb-flex fldb-items-center fldb-cursor-pointer fldb-text-3xl fldb-px-4 fldb-pt-4 fldb-pb-1 hover:fldb-bg-gray-950 fldb-border-r">@svglogo</div><div class="fldb-bg-gray-900 fldb-p-5 fldb-w-full"></div></div><div debugger_pages class="fldb-w-4/5 fldb-h-5/6 my-auto fldb-mx-auto fldb-!max-h-full fldb-overflow-y-scroll fldb-my-auto"></div></div><div class="fldb-hidden fldb-h-full fldb-text-2xl fldb-!bg-gray-950"></div><div ___tailwind_used_classes class="fldb-p-2 fldb-my-2 fldb-hidden fldb-text-3xl fldb-text-2xl fldb-text-xl fldb-my-2 fldb-my-3 fldb-border-r fldb-border-l fldb-py-5 fldb-bg-sunglow fldb-text-gray-900 fldb-px-2 fldb-py-0.5 fldb-rounded fldb-mx-1 fldb-pt-5 fldb-pb-14 fldb-text-lg fldb-font-bold"></div></div>
<!-- Scripts -->
@script(){ {{ $_VIEW->import('./js/compressed.js') }} }@script()
<!-- Styles -->
@style()
{{ $_VIEW->import('./css/compressed.css') }}
@style()
#flame-engine.ignore:start
<style>.___debug_code_block{border-radius:0;border-bottom-right-radius:0;border-bottom-right-radius:3px;font-size:18px;padding:15px;background-color:#262335;width:100%;overflow-y:scroll;border-radius:3px;width:100%;display:block;max-height:300px;overflow:scroll}[debugger__tab_selected]{background-color:#ffca3a!important}</style>
#flame-engine.ignore:end
<!-- END OF DEBUGGER TOOL -->
<!-- {{ str_repeat("-", 50) }} -->