<?php

// connect to the database and check if the login ID exists.
session_start();

$suppliedname = $_GET["uname"];

$suppliedpassword = $_GET["spass"];

$_SESSION["current_user_hash"] = $suppliedpassword;

$myuser="rajat";
$mypass="";
$myser = "localhost:2023";

$mycon = new mysqli($myser,$myuser,$mypass);

if ($mycon->connect_error){
    echo "Connection failed";
    die("Connection failed: ". $con->connect_error);
}

$myusequery = "USE test";

if ($mycon->query($myusequery) === TRUE) {
    
} else {
    echo "Error selecitng database: ". $mycon->error;
}

$myqsql = "SELECT pass FROM fromphp where user = "
        . "'".$suppliedname
        . "'";


$myresult = $mycon->query($myqsql);

$myrow = $myresult->fetch_assoc();

$fetchedpassword = $myrow["pass"];

if ($fetchedpassword=== $suppliedpassword)
    echo "true";
else 
    echo "false";

$mycon->close();



