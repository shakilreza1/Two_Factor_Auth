<?php
define('HOST', 'localhost'); // Database host
define('USER', 'root'); // Database user
define('PASSWORD', ''); // Database user password
define('DATABASE', 'itech_auth'); // Database name
define('CHARSET', 'utf8'); // not mendatory

function DB()
{
    static $instance;
    if ($instance === null) 
    {
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           );
        
        $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;

        $instance = new PDO($dsn, USER, PASSWORD, $opt);
    }
    return $instance;
}

?>