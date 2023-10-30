<?php
    $directory = 'static/img/solid/';

    if(is_dir($directory)){
        $files = array_diff(scandir($directory), array('..', '.'));

        $fileList = array_filter($files, function ($item) use ($directory) {
            return is_file($directory . '/' . $item);
        });

        foreach($fileList as $file){
            echo "/" . $directory . $file . "<br>";
        }
    }
?>