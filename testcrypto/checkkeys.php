<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

echo $_SESSION["public"];

echo "<br><br><br><br>";

echo $_SESSION["private"];

echo "<br><br><br><br>";

echo $_SESSION["aes_key"];

echo "<br><br><br><br>";

echo $_SESSION["current_user_hash"];