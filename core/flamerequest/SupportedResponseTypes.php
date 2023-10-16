<?php

namespace Core\Flame;


enum SupportedResponseTypes: string {
     case HTML = '/\btext\/html\b/';
     case JSON = '/\bapplication\/json\b/';
     case PLAIN = '/\btext\/plain\b/';
     case JAVASCRIPT = '/\bapplication\/javascript\b/';
     case CSS = '/\bapplication\/javascript\b/';
}