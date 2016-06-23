<?php
spl_autoload_register(function ($class) {
    if (strpos($class, "simplon")) {
        $path = str_replace("\\", "/", $class);

        include 'app/' . $path . ".php";
    }
});