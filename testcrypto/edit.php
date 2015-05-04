
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <textarea id="ta" rows="20" style="position: absolute; top: 10%; width: 98%"></textarea>
    <button onclick="update_blog()">Update Blog</button>
        <?php
     
        // Fetch the get URL Queries
        $pass_hash = $_GET["password_hash"];
        
        // compute the file path based on the hash provided
        $blog_file_path = "blogs/".$pass_hash;
        
        // read file contents to a variable
        $blog_contents = file_get_contents($blog_file_path);
        
        // get the contents to an edit window, and on clicking update blog, update it. 
        
        ?>
    
        <!-- Include the necessary Javascript source libraries. -->
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="bin/jsencrypt.min.js"></script>
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/aes.js"></script>
       
    <script>
    
    var js_blog_contents = <?php echo json_encode($blog_contents); ?>;
    var js_pass_hash = <?php echo json_encode($pass_hash); ?>;
    document.getElementById("ta").value = js_blog_contents;
    console.log("The hash of user is " + js_pass_hash);
    console.log("Fetched blog contents are " + js_blog_contents);
    
    function update_blog() {
        
        
        // on update, we encrypt the plaintext data and send it for updation.
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
        console.log("We got this: " + myxmlhttp.responseText);
        }
        }
        
        //xmlhttp.open("GET","demo_get.asp",true);
        //xmlhttp.send();
        
        
        // ENCRYPT THE DATA
        var plain_text= document.getElementById("ta").value;
        var aes_key = localStorage.getItem("aesKey");
        console.log("key being used is " + aes_key);
        var string = CryptoJS.AES.encrypt(plain_text, aes_key);
        console.log("Encrypted string is " + encodeURIComponent(string));

        
        // FIRE THE DATA
     //   var body = "update_text=" + encodeURIComponent(string);
     //   myxmlhttp.open("GET", "updateblog.php?" + body, true);
        //myxmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
       // myxmlhttp.send(body);
     //  myxmlhttp.send();
        
    }
    
    
    </script>    
    
    </body>
</html>
