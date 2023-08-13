<?php

use Core\Framework\Console\Color\BackgroundColor;
use Core\Framework\Console\Color\Color;
use Core\Framework\Console\Color\ForegroundColor;

function warn($text = '') {
     echo Color::Color(' WARNING ', ForegroundColor::BLACK, BackgroundColor::YELLOW) 
     . Color::Foreground(' ' . $text, ForegroundColor::YELLOW) . "\n";
}