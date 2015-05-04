<?php

/*
 * 
 * Clean : just send the blog text and get it updated !
 * 
 */

session_start();

$user_hash_var = $_SESSION["current_user_hash"];

$blog_Text = $_POST["update_text"];

// skipping decryption for now 

// perform decryption 

$blog_plain_text = $blog_Text;

$myfile = fopen("blogs/".$user_hash_var,"w");

fwrite($myfile, $blog_Text);

fclose($myfile);


?>