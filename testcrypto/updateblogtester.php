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
        <?php
        // put your code here
        
        session_start();
        
        $_SESSION["current_user_hash"]="rohanpass";
        
        ?>
        <script>
        
        
        
        var xmlhttp;
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        
        //    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
        
        console.log("We got this: " + xmlhttp.responseText);
        
        }
        }
        
        //xmlhttp.open("GET","demo_get.asp",true);
        //xmlhttp.send();
        
        var string= "this is a super large string";

        var body = "update_text=" + encodeURIComponent(string);
        
        xmlhttp.open("POST", "updateblog.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
       // xmlhttp.setRequestHeader("Content-Length", body.length);
      //  xmlhttp.setRequestHeader("Connection", "close");
        xmlhttp.send(body);
        
        
        
        </script>
    </body>
</html>
