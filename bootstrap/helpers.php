<?php


function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}


function pr($data){
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}