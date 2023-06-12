<?php
require_once '../vendor/autoload.php';

header('Content-type: text/plain; charset=utf-8');

ini_set('display_errors', 1);
error_reporting(E_ALL);

use Medoo\Medoo;
// Connect to the database.
// $database = new Medoo([
//     'type' => 'mysql',
//     'host' => 'localhost',
//     'database' => 'consulations',
//     'username' => 'root',
//     'password' => '',
// ]);

$database = new Medoo([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'agenciad_consulation',
    'username' => 'agenciad_mster',
    'password' => '$Delakal21',
]);
?>