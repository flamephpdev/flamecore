<?php

namespace Core\Flame;

class RequestBodyParser {
     public readonly string $method;
     public readonly ?array $body;

     public function __construct() {
          $data = NULL;
          $method = SupportedMethods::tryFrom(strtolower($_SERVER['REQUEST_METHOD'])) ?? SupportedMethods::GET;
          if(in_array($method->value, ['post', 'put'])) $data = $this->parseRequestBody();
          if(!is_null($data) && isset($data['_method'])) {
               $method = SupportedMethods::tryFrom(strtolower($data['_method'])) ?? SupportedMethods::POST;
               unset($data['_method']);
          }
          $this->method = $method->value;
          $this->body = $data;
     }

     private function parseRequestBody(): array {
          if(!empty($_POST)){
               return $_POST;
          } else {
               $json = file_get_contents('php://input');
               if(isJson($json)){
                    return json_decode($json,true);
               } else return [];
          }
          return [];
     }

     // public functions
     public function has(string $field): mixed {
          if($this->body && in_array($field, array_keys($this->body))) {
               return $this->body[$field];
          } else return false;
     }

     public function validate(array $validation, array $messages = []): RequestValidator {
          $validator = new RequestValidator($validation, $messages);
          $validator->make();
          return $validator;
     }
}