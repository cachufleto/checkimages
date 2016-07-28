<?php
/**
 * Created by ceidodev.com
 * User: User
 * Date: 20/07/2016
 * Time: 12:10
 */
include '../Functions/functions.inc.php';

$data = isset($_GET['data'])? $_GET['data'] : '';

if(variablenumerique($data)){
    echo "<br>variablenumerique($data)";
}

if(variabletexte($data)){
    echo "<br>variabletexte($data)";
}

if(numerique($data)){
    echo "<br>numerique($data)";
}

if(codeceido($data)){
    echo "<br>codeceido($data)";
}

/*
function varnum($data)
{
    if(empty($data) OR preg_match('#[a-zA-Z+-!]#')){
        return true;
    }

    return false;
}

function varchar($data)
{
    if(empty($data)){
        return true;
    }

    return false;
}

function num($data)
{
    if(empty($data) OR $data < 1 OR !is_int($data)){
        return true;
    }

    return false;
}

function codeceido($data)
{
    if (empty($data) OR preg_match('#^0]#')) {
        return true;
    }

    return false;
} */