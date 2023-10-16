<?php

namespace Core\Flame;

class RequestQueryParser {
     public readonly array $query;

     public function __construct() {
          $this->query = $_GET;
     }

     public function validate(array $validation, array $messages): RequestValidator {
          $validator = new RequestValidator($validation, $messages);
          $validator->make($this->query);
          return $validator;
     }
}