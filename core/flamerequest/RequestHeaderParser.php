<?php

namespace Core\Flame;

use Core\App\Session;

class RequestHeaderParser {
     public readonly array $headers;
     public readonly string $clientPublicIp;
     public readonly ?string $origin;
     public readonly array $cookies;
     public readonly Session $session;
     public readonly string $operationSystem;
     public readonly string $browser;
     public readonly SupportedResponseTypes $responseType;

     public function __construct() {
          $this->headers = apache_request_headers();
          $this->clientPublicIp = ip();
          $this->origin = $_SERVER['HTTP_ORIGIN'] ?? NULL;
          $this->cookies = $_COOKIE ?: [];
          $this->session = new Session;
          $this->operationSystem = getOS();
          $this->browser = getBrowser();
          foreach(SupportedResponseTypes::cases() as $resType) {
               if(preg_match($resType->value, $this->headers['Accept'] ?: '')) {
                    return $this->responseType = $resType;
               }
          }
          if(!isset($this->responseType)) $this->responseType = SupportedResponseTypes::HTML;
     }
}