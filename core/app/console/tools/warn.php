<?php

use Core\Framework\Console\Color\BackgroundColor;
use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;

if(!function_exists('warn')) {
     function warn($text = '') {
          echo Color::Color(' WARNING ', ForegroundColor::BLACK, BackgroundColor::YELLOW) 
          . Color::Foreground(' ' . $text, ForegroundColor::YELLOW) . "\n";
     }
}

if(!function_exists('error')) {
     function error($text = '') {
          echo Color::Color(' ERROR ', ForegroundColor::BLACK, BackgroundColor::RED) 
          . Color::Foreground(' ' . $text, ForegroundColor::RED) . "\n";
     }
}

if(!function_exists('success')) {
     function success($text = '') {
          echo Color::Color(' SUCCCESS ', ForegroundColor::WHITE, BackgroundColor::LIGHT_GREEN) 
          . Color::Foreground(' ' . $text, ForegroundColor::LIGHT_GREEN) . "\n";
     }
}

if(!function_exists('info')) {
     function info($text = '') {
          echo Color::Color(' INFO ', ForegroundColor::WHITE, BackgroundColor::BLUE) 
          . Color::Foreground(' ' . $text, ForegroundColor::BLUE) . "\n";
     }
}