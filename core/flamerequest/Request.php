<?php

namespace Core\Flame;

use Core\App\Request as AppRequest;
use Core\App\Response;
use Core\App\Session;

class Request {

     private static Request $request;

     // object methods
     public function __construct(
          public readonly string $method,
          public readonly array $fileNames,
          public readonly RequestHeaderParser $header,
          public readonly RequestBodyParser $body,
          public readonly RequestQueryParser $query,
     ) {
          // for some time, the old Request class should catch too
          AppRequest::catch();
     }

     // methods
     public function cookies(): array {
          return $this->header->cookies;
     }

     public function session(): Session {
          return $this->header->session;
     }

     public function clientIp(): string|null {
          return $this->header->clientPublicIp;
     }

     public function origin(): ?string {
          return $this->header->origin;
     }

     public function headers(): array {
          return $this->header->headers;
     }

     public function method(): string {
          return $this->body->method;
     }

     public function body(): ?array {
          return $this->body->body;
     }

     public function queryParams(): ?array {
          return $this->query->query;
     }

     public function path(): string {
          return urldecode(
               parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
          );
     }

     public function responseType(): string {
          return $this->header->responseType->name;
     }

     public function wantsJson(): bool {
          return $this->header->responseType == SupportedResponseTypes::JSON;
     }

     public function response(): Response {
          return new Response($this);
     }

     // static methods
     public static function catch(): void {
          $headerParser = new RequestHeaderParser();
          $bodyParser = new RequestBodyParser();
          $queryParser = new RequestQueryParser();

          $request = new Request(
               $bodyParser->method,
               array_keys($_FILES),
               $headerParser,
               $bodyParser,
               $queryParser
          );

          self::$request = $request;
     }

     public static function Current(): Request {
          return self::$request;
     }

}