<?php

namespace Core\Flame\Storage;

use Exception;

class File {

     private string $blobUrl;
     public readonly string $name;
     public readonly int|float $size;
     public readonly string $type;
     public readonly string $extension;
     public readonly string $uniqId;
     private string $saveName;

     public function __construct(bool $newFile = false, string $blobUrl = '', string $name = '', int|float $size = 0, string $type = '') {
          if($newFile) {
               $this->blobUrl = $blobUrl;
               $this->name = $name;
               $this->size = $size;
               $this->type = $type;
               $this->extension = $this->getExtension();
               $this->createUniqId();
          }
     }

     public function preLoad(string|array $saveNames) {
          $created = array();
          if(!is_array($saveNames)) $saveNames = array($saveNames);
          $single = count($saveNames) == 1;
          $headers = $this->headerControl()->get($saveNames);

          foreach($headers as $name => $headers) {
               $path = $this->path($name);
               if(!file_exists($path)) {
                    $created[$name] = false;
               } else if(!$single) {
                    $tmpFile = new $this(false);
                    $tmpFile->saveName = $name;
                    $tmpFile->name = $headers->name;
                    $tmpFile->extension = $headers->extension;
                    $tmpFile->size = $headers->size;
                    $tmpFile->type = $headers->type;
                    $tmpFile->uniqId = $headers->uniqId;
                    $created[$name] = $tmpFile;
               } else {
                    $this->saveName = $name;
                    $this->name = $headers->name;
                    $this->extension = $headers->extension;
                    $this->size = $headers->size;
                    $this->type = $headers->type;
                    $this->uniqId = $headers->uniqId;
               }
          }
          if($single) return $this;
          return $created;
     }

     public function getExtension(): string {
          $exp = explode('.', $this->name);
          return $exp[array_key_last($exp)];
     }

     public function isImage(): bool {
          if(!function_exists('getimagesizefromstring')) throw new Exception('The GD Image extension is not available!');
          $s = getimagesize($this->blobUrl);
          return @is_array($s) ? true : false;
     }

     public function save() {
          while (file_exists($this->path($this->saveName))) {
               $this->createUniqId();
          }
          $write = move_uploaded_file(
               $this->blobUrl,
               $this->path($this->saveName)
          );
          $createFileHelper = $this->makeFileHelp();
          return $write !== false && $createFileHelper;
     }

     public function download() {
          header('Content-Type: application/' . $this->type);
          header('Content-Transfer-Encoding: Binary');
          header('Content-disposition: attachment; filename="' . $this->name . '"');
          readfile($this->path($this->saveName));
          exit;
     }

     private function createUniqId() {
          $this->uniqId = strval(microtime(true)) . '.' . hash('sha256', '&' . $this->name . '&' . $this->size);
          $this->createSaveName();
     }

     private function createSaveName() {
          $this->saveName = $this->uniqId . '.' . $this->extension;
     }

     private function path($file) {
          $sp = substr(endStrSlash(_env('STORE_PATH')), 0, -1);
          return $sp . startStrSlash($file);
     }

     private function makeFileHelp() {
          $help = array(
               'name' => $this->name,
               'extension' => $this->extension,
               'size' => $this->size,
               'type' => $this->type,
               'uniqId' => $this->uniqId,
          );
          return $this->headerControl()->set($this->saveName, $help);
     }

     private function headerControl() {
          return Settings('FileStorageHeaderControl');
     }

}