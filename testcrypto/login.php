<html>




    <head>
        
    </head>


    <body>
        <input id="registerid" type="text" style="position: absolute; top: 40%; left: 50%" value="ID"/> 
        <input id="registerpass" type="password" style="position: absolute; top: 45%; left: 50%" value="Password"/> 
        <input onclick="validate()" type="button" style="position: absolute; top: 50%; left: 50%" value="Login"/> 
        
        <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha3.js"></script>
        <script>
        
        function validate(){
            
            var s_username = document.getElementById("registerid").value;
            console.log("Username: " + s_username);
            
            var s_password = document.getElementById("registerpass").value;
            console.log("Password: " + s_password);
            
            
            // hash the password
            var sha3hash = CryptoJS.SHA3(s_password);
            
            
            
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
                        
                    var response  = xmlhttp.responseText;
                            console.log("Response is " + response);
                            
                    if (response==="true") {
                        
                        console.log("User is authenticated.");
                        
                        //window.open("edit.php?password_hash="+s_password);
                        
                        window.open("edit.php?password_hash="+sha3hash);
                        
                    }   else if (response==="false") {
                        console.log("Unable to authenticate.");  
                    }   
                 
                 
                 
                    }
                }
            
            //xmlhttp.open("GET","validatelogin.php?uname=" + s_username  + "&spass=" + s_password,true);
            
            xmlhttp.open("GET","validatelogin.php?uname=" + s_username  + "&spass=" + sha3hash,true);
            xmlhttp.send();
            
        }
        
        </script>
        
        
</body>
        
</html>