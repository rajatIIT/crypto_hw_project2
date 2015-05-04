<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <button style="position: absolute; left: 50%; top: 45%">View blogs</button>
        
        <a href="login.php"><button style="position: absolute; left: 50%; top: 50%">Edit Blogs</button></a>
        
        <a href="register.php"><button style="position: absolute; left: 50%; top: 55%">Register</button></a>
        
        <?php
        // put your code here
        ?>
        
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="bin/jsencrypt.min.js"></script>
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
        <script>
    
            var turned_public_key;
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
                        
                        // generate a new key pair on server and get the public
                        // key for encryption
                        turned_public_key= xmlhttp.responseText;
                        console.log("public key returned is " + turned_public_key);
                        
                        var aes_key = CryptoJS.enc.Hex.parse('000102030405060708090a0b0c0d0e0f');
                        var fetchedpubilckey=turned_public_key;
                        var aes_key = CryptoJS.enc.Hex.parse('000102030405060708090a0b0c0d0e0f');
                        // encrypt this AES key and send
                        
                        var encryptiontext = "000102030405060708090a0b0c0d0e0f";
                        localStorage.setItem("aesKey",encryptiontext);
                
                        console.log("AES Key : " + encryptiontext);
                
                        // encrypt the public key
                        var encrypt = new JSEncrypt();
                        encrypt.setPublicKey(fetchedpubilckey);
                        var encrypted = encrypt.encrypt(encryptiontext);
                
                        console.log("encrypted KEY: "+  encodeURIComponent(encrypted));
                
                    }
                }
            
            xmlhttp.open("GET","keygenerationforclient.php",true);
            xmlhttp.send();
            
            
        </script>
    </body>
</html>
