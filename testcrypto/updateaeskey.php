<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();

$aes_key = $_GET["aes_private_key"];

$_SESSION["aes_key"] = $aes_key;

