<?php

namespace App\Controller;

use Core\Base\Controller;

class MainController extends Controller {

     /**
      * The controller's index method, that returns the home page
      */
     public function index(){
          /**
               * The navbar config
          */
          $links = $this->navbar();

          return view('index',[
               // then return the links as links
               'links' => $links,
               // and some home page info
               /**
                * Every main array key converted to a variable
                * Like: view('demo',['id' => 1])
                * Then use the variable in the view like: Id: {{ $id }}
                */
               'title' => 'Flame Core',
               'description' => 'Build modern and super slim <b>MVC</b> applications with PHP.',
          ]);
     }

     private function navbar(){
          if(_env('USE_AUTH')){
               // if auth enabled
               if(!user()){
               // if the user is not logged in
               return [
                    ['href' => route('index'), 'title' => 'Home', 'active'],
                    ['href' => route('auth.login'), 'title' => 'Login'],
                    ['href' => route('auth.register'), 'title' => 'Register'],
               ];
               }
               // if the user is logged in
               return [
                    [ 'href' => route('index'), 'title' => 'Home', 'active' ],
                    [ 'href' => route('dash'), 'title' => 'Dashboard' ],
                    [ 'href' => route('user', user()->username), 'title' => 'My Profile' ],
                    [ 'href' => route('auth.logout'), 'title' => 'Logout' ],
               ];
          }

          // if the auth is not enabled
          return [ ['href' => route('index'), 'title' => 'Home', 'active'] ];
     }

}