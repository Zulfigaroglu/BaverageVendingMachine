<?php
function loadDirectory($directory) {
    $files = scandir($directory);

    foreach ($files as $key => $value) {
        if($value[0] !== '.') {
            $path = $directory . '/' . $value;
            $realpath = realpath($path);

            if(is_dir($realpath)) {
                loadDirectory($path);
                continue;
            }


            require_once($path);
        }
    }
}

loadDirectory('app');
loadDirectory('test');