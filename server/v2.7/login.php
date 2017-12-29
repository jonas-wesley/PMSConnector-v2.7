<?php

# initialize session
session_start();
if(isset($_POST['user_pass'])) {
    
$p = $_POST['user_pass'];

include "res/server-config/server-config.php";

  if( $p != $server_admin_pass) {
    echo "
         <script>alert('invalid pass.')</script>
         ";
  } else {
    
    $_SESSION['user_pass'] = $p;
    
    # redirect to editor
    echo "
          <script>location.href='main.php'</script>
         ";
    
  }
}
?>


<html>
    <head>
        <title>
            admin login
        </title>
    </head>
    <body>
        
        <form action='login.php' method='post'>
            <input type='password' name='user_pass' placeholder='your pass'>
            <input type='submit' value='login'>
        </form>
        
    </body>
</html>
