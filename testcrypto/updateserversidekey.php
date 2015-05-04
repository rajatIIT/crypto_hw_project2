<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    
    <body>
       
        <?php
        session_start();
        $encrypted_key = $_GET["encryptedkey"];
        $private_key = $_SESSION["private"];
        
        ?>
        
        
          <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="bin/jsencrypt.min.js"></script>
        
        
        <script>
        
        var js_privatekey = <?php echo json_encode($private_key); ?>;
        var js_encryptedkey = <?php echo json_encode($encrypted_key); ?>
        
        console.log("private key is " + js_privatekey);
        console.log("encrypted key is " + js_encryptedkey);
        
        var decrypt = new JSEncrypt();
        decrypt.setPrivateKey(js_privatekey);
        var uncrypted = decrypt.decrypt(js_encryptedkey);
        
        console.log("Decrypted data: " + uncrypted);
        
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
        xmlhttp.open("GET","updateaeskey.php?aes_private_key=" + uncrypted,true);
            xmlhttp.send();
            
        
        
        </script>
        
        <?php
        
        
        ?>
        
    </body>
    
</html>