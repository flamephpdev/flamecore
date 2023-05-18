<?php

use App\Errors\Log\RunLog;

function runtimeLog($message){
     RunLog::add($message);
}