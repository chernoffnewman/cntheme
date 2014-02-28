<?php 

// load all php files in functions folder
$files = preg_grep('/^([^.])/', scandir(dirname(__FILE__).'/functions/'));
foreach ($files as $filename) {
    $path = dirname(__FILE__) . '/functions/' . $filename;
    if (is_file($path)) {
      require $path;
    }
}