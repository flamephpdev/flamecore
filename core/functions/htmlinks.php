<?php

function urlOrAsset($asset){
    if(!filter_var($asset, FILTER_VALIDATE_URL)){
        return asset($asset);
    }
    return $asset;
}

function stylesheet($style,$attrs = ''){
    return '<link rel="stylesheet" href="'. urlOrAsset($style) . '"' . $attrs . '>' . "\n";
}

function script($script = NULL,$attrs = ''){
    if(!is_null($script)) return '<script src="'. urlOrAsset($script) . '"' . $attrs . '></script>' . "\n";
    if(!isset($GLOBALS['htmlinks___']['script_close'])) $GLOBALS['htmlinks___']['script_close'] = false;
    $GLOBALS['htmlinks___']['script_close'] = !$GLOBALS['htmlinks___']['script_close'];
    if(!$GLOBALS['htmlinks___']['script_close']) return "</script>";
    else return "<script>";
}