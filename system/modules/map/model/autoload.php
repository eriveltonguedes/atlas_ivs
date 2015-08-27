<?php

/**
 * Autoload Class.
 * 
 * @package map
 * @author AtlasBrasil
 */

/**
 * Autoload.
 * 
 * @param string $class_name
 */
function __autoload($class_name)
{
    $path = dirname(__FILE__) . '/';
    $file = $path . $class_name . '.php';

    if (file_exists($file))
    {
        require_once $file;
    }
    else if (strtolower(substr($class_name, -3)) == 'dao')
    {
        require_once $path . 'Dao/' . $class_name . '.php';
    }
    else if (strtolower(substr($class_name, 0, 4)) == 'util')
    {
        require_once $path . 'Utils/' . $class_name . '.php';
    }
    else
    {
        if (file_exists($path . 'Utils/' . $class_name . '.php'))
        {
            require_once $path . 'Utils/' . $class_name . '.php';
        }
        else
        {
            require_once $path . 'Entity/' . $class_name . '.php';
        }
    }
}
