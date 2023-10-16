<?php

namespace Core\Flame;

use Core\App\RegEx;
use Exception;

class RequestValidator {
     protected array $collectedErrors = [];
     protected array $validated = [];
     /**
      * @param array $validation The validation array https://flamephp.mrtn.vip/docs/v1/request/validation
      * @param $errorMessages Rewrite the basic error messages, like: "regex" to "Username should not contain special characters"
      */
     public function __construct(
          protected array $validation, 
          protected array $errorMessages = []
     ) {}

     public function isDataValid(): bool {
          return empty($this->collectedErrors);
     }

     public function getValidatedData($force = false): ?array {
          if($this->isDataValid() || $force) return $this->validated;
          return NULL;
     }

     public function getErrors(): array {
          return $this->collectedErrors;
     }

     // logic functions
     /**
      * @param array $customData Use custom data or the currently requested data
      */
     public function make(?array $customData = NULL) {
          $data = $customData ? $customData : Request::Current()->body();
          $validated = array();

          foreach($this->validation as $field => $rules) {
               if(is_string($rules)) $rules = explode('|', $rules);
               if(!is_array($rules)) throw new Exception('Invalid rule set');

               $nullable = in_array('nullable', $rules);

               if(isset($data[$field]) && $data[$field] != '') {
                    // unset nullable from rules
                    if($nullable) $rules = array_diff($rules, ['nullable']);

                    // get the rule and the errorMessage from the array
                    foreach($rules as $rule => $errorMessage){
                         $_ = $this->getRule($rule, $errorMessage);
                         // validate the rule
                         $this->validateRule($_[0], $_[1], $field, $data[$field]);
                    }

                    // check for errors
                    if(!in_array($field, array_keys($this->collectedErrors))) $validated[$field] = $data[$field];
               } else if($nullable) {
                    $validated[$field] = NULL;
               } else $this->addFieldError($field, 'required');
          }

          $this->validated = $validated;
     }

     protected function addFieldError(string $field, string $errorKey, $customError = false) {
          if(!$customError) $errorKey = $this->generateErrorMessage($errorKey);
          $this->collectedErrors[$field] = $errorKey;
     }

     protected function generateErrorMessage(string $errorKey, $value = NULL) {
          if(isset($this->errorMessages[$errorKey])) {
               if(is_null($value) || !$value) return $this->errorMessages[$errorKey];
               return str_replace(':val:', $value, $this->errorMessages[$errorKey]);
          }
          return $errorKey;
     }

     protected function getRule($rule, $errorMessage = NULL) {
          if(is_numeric($rule)) return array($rule, NULL);
          return array($rule, $errorMessage);
     }

     protected function validateRule($rule, string $errorMessage, string $field, $data) {
          $customError = !is_null($errorMessage);
          
          if(is_string($rule)) {
               if(str_contains($rule, ':')) {
                    $rule = explode(':',$rule);
               } else $rule = [$rule];
               [$succeed, $message] = $this->handleValidation($data, ...$rule);
               if(!$succeed) $this->addFieldError($field, $customError ?: $message, $customError);
          } else if(is_callable($rule)) {
               if(!$rule($data, $field)) {
                    $this->addFieldError($field, $errorMessage ?: 'callback', $customError);
               }
          }
     }

     protected function handleValidation($value, string $rule, $ruleValue = NULL): array {
          $succeed = true;
          $message = $rule;
               
          switch($rule) {
               case 'regex': {
                    if(!preg_match(RegEx::get($ruleValue), $value)) {
                         $succeed = false;
                    }
                    break;
               }
               case 'min' || 'max': {
                    $len = intval($ruleValue);
                    if($rule == 'min') $succeed = strlen($value) >= $len;
                    else if($rule == 'max') $succeed = strlen($value) <= $len;
                    break;
               }
               case 'email': {
                    $succeed = RegEx::is_email($value);
                    break;
               }
          }
          
          return [$succeed, $message];
     }
}