<?php

namespace Core\Flame\Storage;

use Core\Base\Base;
use Core\Base\ModelBase;

class FileHeaderControlDatabaseModel extends Base {

     private ModelBase $model;
     private object $config;

     public function __construct(ModelBase $model, ?array $fieldConfig = NULL) {
          $this->model = $model;
          if(is_array($fieldConfig)) $this->config = (object) $fieldConfig;
          else $this->config = (object) array(
               'name' => 'name',
               'extension' => 'extension',
               'size' => 'size',
               'type' => 'type',
               'uniqId' => 'uniq_id',
          );
     }

     public function get(array|string $saveNames) {
          if(!is_array($saveNames)) $saveNames = array($saveNames);
          $uniqIds = array();

          foreach($saveNames as $name) {
               $uniqIds[] = $this->getUniqId($name);
          }
          $datas = array();

          $model_data = $this->model->select('*')->where([
               $this->config->uniqId => $uniqIds
          ])->get(false);
          
          foreach($model_data as $data) {
               $datas[
                    $data[$this->config->uniqId] . '.' . $data[$this->config->extension]
               ] = (object) array(
                    'name' => $data[$this->config->name],
                    'extension' => $data[$this->config->extension],
                    'size' => $data[$this->config->size],
                    'type' => $data[$this->config->type],
                    'uniqId' => $data[$this->config->uniqId],
               );
          }

          return $datas;
     }

     public function set(string $saveName, array $data) {
          $uniqId = $this->getUniqId($saveName);
          $insert = $this->model->create(array(
               $this->config->name => $data['name'],
               $this->config->extension => $data['extension'],
               $this->config->size => $data['size'],
               $this->config->type => $data['type'],
               $this->config->uniqId => $uniqId,
          ));
          return $insert !== false;
     }

     private function getUniqId(string $saveName): string {
          $e = explode('.', $saveName);
          unset($e[array_key_last($e)]);
          return implode('.', $e);
     }

}