<?php

/*
 * Config paths.
 * 
 * @author AtlasBrasil
 */

$base = 'ivs';

$dominio = "";

$path_dir = "{$dominio}/{$base}/";

// não remover/alterar
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define('BASE_ROOT', "c:/ms4w/apps/$base/");
} else {
    define('BASE_ROOT', "/var/www/$base/");
}
