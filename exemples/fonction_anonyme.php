<?php

$users = ['Jo', 'Luc', 'Bob'];

$USERS = array_map('strtolower', $users);

var_dump($USERS);

echo '</br></br>';


$maFunction = function ($item) {
    return strtoupper($item);
};

$USERS = array_map($maFunction, $users);
var_dump($USERS);
echo '</br></br>';

?>