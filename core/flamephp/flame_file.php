<?php

namespace Views\Files;

class FlameFile {

     public readonly string $file;
     private string $_path;
     private array $__viewconf = array();
     private string $_view_root;
     private string $view_cache_root;
     private array $applockToken;

     public function __construct($file) {
          $this->file = $file;
          $this->_path = dirname($file);
          $this->__viewconf = config('view');
          $this->_view_root = path(substr(endStrSlash($this->__viewconf['view-folder']), 0, -1));
          $this->view_cache_root = path(cache('/views'));
          $this->applockToken = require core('applock.token.php');
     }

     public function rootPath($path, $real = false) {
          if(!$real) $root = $this->_view_root;
          else $root = $this->view_cache_root;
          return path($root . startStrSlash($path));
     }

     public function realPath($path = '*') {
          if(str_starts_with($path, '*')) return path($this->rootPath(substr($path, 1), true));
          return path($this->_path . startStrSlash($path));
     }

     private function path($path = '*') {
          if(str_starts_with($path, '*')) $path = $this->rootPath(substr($path, 1));
          else $path = $this->_path . startStrSlash($path);
          $path = path($path);
          $path = str_replace(path($this->view_cache_root . '/'), '', $path);
          $path = str_replace(
               $this->applockToken['framework_builtin_views_directory'],
               '.src/:',
               $path
          );
          return $path;
     }

     public function import($file) {
          view($this->path($file));
     }

};