<?php

// fetch the GET request query parameters.
$query_user = $_GET["user_name"];

$query_hash = $_GET["user_hash"];

// DATABASE SETTINGS
// PLEASE CHANGE THE USER AND PASS FOR YOUR PARTICULAR CASE
$myuser="rajat";
$mypass="";
$myser = "localhost:2023";

$mycon = new mysqli($myser,$myuser,$mypass);


if ($mycon->connect_error){
    echo "Connection failed";
    die("Connection failed: ". $con->connect_error);
}

// select the appropriate database.
$myusequery = "USE test";

if ($mycon->query($myusequery) === TRUE) {
    
} else {
    echo "Error selecting database: ". $mycon->error;
}

// query to insert the values into the database.
$insert_query  = "insert into fromphp "
        . "(user,pass) values "
        . "(\"".$query_user ."\",\"".$query_hash."\");";


// this output is displayed in the javascript console while testing. 
if($mycon->query($insert_query) === TRUE) {
echo "You are succesfully registered";    

// create a new file with the name of the hash
// this file is used to store the blog contents 
$current_user_blog_file_path = "blogs/".$query_hash;
$current_user_blog_file = fopen($current_user_blog_file_path,"w") or die("Unable to open file!");
fwrite($current_user_blog_file, " ");
fclose($current_user_blog_file);

} else {
    echo "Unable to register !";
}

?>
