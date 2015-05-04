<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <input id="userid" type="text" style="position: absolute; left: 50%; top: 40%" value="User"/>
        
        <input id="passid" type="password" style="position: absolute; left: 50%; top: 50%" value="Password"/>
        
        <button id="register" style="position: absolute; left: 50%; top: 60%" onclick="register()">Register Now</button>
               
               
        
        
        <?php
        // put your code here
        ?>
        
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>
        <script>
        
        function register(){
        
        // Computer the HASH ; We use the cryptoJS Library
        var u_name = document.getElementById("userid").value;
        var pass = document.getElementById("passid").value;
        var hash = CryptoJS.SHA3(pass);
        console.log("Computed hash: for " + pass + " : " + hash);
        
        
        // send request to server to create a new entry in the database
        var myxmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            myxmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            myxmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        myxmlhttp.onreadystatechange=function()
        {
        if (myxmlhttp.readyState==4 && myxmlhttp.status==200)
        {
        console.log("We got this result: " + myxmlhttp.responseText);
        }
        };
        
        
        var request_body = "user_name=" + u_name + "&user_hash=" + hash;
        myxmlhttp.open("GET", "createuser.php?" + request_body, true);
        myxmlhttp.send();
        }
        
        
        </script>
    </body>
</html>
