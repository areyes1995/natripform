<?php

header('Content-type: text/plain; charset=utf-8');

require './vendor/autoload.php';

use Medoo\Medoo;

// Connect to the database.
$database = new Medoo([
    'type' => 'mysql',
    'host' => 'https://agenciadeviajes.do/',
    'database' => 'agenciad_consulation',
    'username' => 'agenciad',
    'password' => 'Eydam862301',
]);

print_r($database);