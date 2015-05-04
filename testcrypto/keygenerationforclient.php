  
        <?php
        session_start();
        
        //Create an encrypt and decrypt mech and test it.
        
        // generate private key with openssl
        exec("openssl genrsa -out key.pem",$out_execute);
        
        $pkeycontents = file_get_contents("key.pem");
     
        $_SESSION["private"]=$pkeycontents;
        
        
        
        // generate public key with openssl
        exec("openssl rsa -in key.pem -pubout -out pub-key.pem");
        
        $pubkeycontents = file_get_contents("pub-key.pem");
        
        $_SESSION["public"]=$pubkeycontents;
        
        echo $pubkeycontents;
        
/*
        
       <script>
        
        var generatedprivatekey = <?php echo json_encode($pkeycontents) ?>;
        var generatedpublickey =  <?php echo json_encode($pubkeycontents) ?>;
        
        console.log("generated private: " + generatedprivatekey);
        console.log("generated public: " + generatedpublickey);
        
        </script>

  */      
        
        
        ?>