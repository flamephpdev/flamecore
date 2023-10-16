<?php

namespace Core\Flame;


enum SupportedMethods: string {
     case GET = 'get';
     case POST = 'post';
     case PUT = 'put';
     case DELETE = 'delete';
     case PATCH = 'patch';
}