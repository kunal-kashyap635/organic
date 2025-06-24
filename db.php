<?php

function db(){
    $con = new mysqli("localhost","root","","organic");
    return $con;
}


?>