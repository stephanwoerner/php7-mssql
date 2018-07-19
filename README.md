# php7-mssql
Use old mssql functions with php7* based on PDO ans Sybase

You requires php7.0-sybase

On Debian you can install it with

apt-get install php7.0-sybase

I only implement few functions for basic funktionalality
and I supplie you also with a class to use the functions easier

#Example 1

````
<?php
require 'mssql.php';

define('MSSQL_HOST', '192.168.0.81');
define('MSSQL_USER', 'test');
define('MSSQL_PASSWORD', 'test');
define('MSSQL_DATABASE', 'turista');

$conection = mssql_connect(MSSQL_HOST, MSSQL_USER, MSSQL_PASSWORD);
mssql_select_db(MSSQL_DATABASE, $conection);

$executedQuery = mssql_query('select * from users', $conection);
print_r(mssql_fetch_object($executedQuery));
        
````
#Example 2

````
<?php
require 'mssql.php';

define('MSSQL_HOST', '192.168.0.81');
define('MSSQL_USER', 'test');
define('MSSQL_PASSWORD', 'test');
define('MSSQL_DATABASE', 'turista');

$db = new DB();

$db->query('select * from users');
print_r($db->getAll());

