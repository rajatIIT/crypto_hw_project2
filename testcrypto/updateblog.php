<html>

    <head>
        
    </head>

    <body>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
$my_aes_key = $_SESSION["aes_key"];
#$blog_Text = $_POST["update_text"];

$blog_Text = $_GET["update_text"];

?>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
    <script>
        
        var blog_encrypted_text = <?php echo json_encode($blog_Text); ?>;
        // decrypt the text using the current AES key.
        var aes_key = <?php echo json_encode($my_aes_key); ?>;
        var decrypted = CryptoJS.AES.decrypt(blog_encrypted_text, aes_key);
        var final_blog_text = decrypted.toString(CryptoJS.enc.Utf8);
        
        console.log("encrypted text: " + blog_encrypted_text);
        console.log("final blog text: " + final_blog_text); 
        console.log("This content is updates in the system."); 
        
        // now update the blog with plaintext
        
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
                        
                }
                }
               
                
                var body = "update_text=" + encodeURIComponent(final_blog_text);
                xmlhttp.open("POST", "updateuserblog.php", true);
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send(body);
           
    </script>
</body>
</html>