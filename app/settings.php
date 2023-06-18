<?php

// View Engines
use Cache\Views\Flame\FlameRender;
// Or:
// use Core\Cache\View;

// File Header Controllers
use Core\Flame\Storage\FileHeaderControlSpecialFiles as FileHCSF;
// use Core\Flame\Storage\FileHeaderControlDatabaseModel as FileHCDM;
// $fileHCDM = new FileHCDM(new \App\Model\FileSavingModel, /* Array config, not required for scheme based models */);

return array(
     // Rendering engine (FlameRender or View)
     'ViewRenderEngine' => FlameRender::class,
     // Store file information without reading the entire file
     // Options:
     // FileHCSF: File Header stored in a special file wich is easily accessible without connecting to the database
     // With too many files this can cause performance issues, but it's still a great choice if your app doesn't have a database
     // FileHCDM: File Header stored in the database with a fast model
     'FileStorageHeaderControl' => new FileHCSF, // $fileHCDM
);