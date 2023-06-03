<?php

use Views\Views\FlameView;

function FlameView(callable|null|string $callback = NULL) {
     $view = new FlameView();
     if(is_string($callback) && $callback === '::init-file-flameEngine::') return $view;
     else if(is_string($callback) && $callback === '::end-file-flameEngine.BackState::') $view->back();
     else if(is_string($callback)) throw new Exception('String cannot be used with callback');
     if(!$callback || !is_callable($callback)) return $view->file();
     return $callback($view->file());
}