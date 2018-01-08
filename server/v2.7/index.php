<?php

if(!file_exists("res/server-config/server-config.php")) {
    
   if(getenv("REQUEST_METHOD")=="POST") {
      # generate this on 
      $crypt_salt = uniqid(mt_rand(), true);
	  
      # erros
      $error = 0;
      $msg = "is empty...";
      
      if(empty($_POST['server-database-host'])) {
        $error = 1;
      } elseif(empty($_POST['server-database-port'])) {
        $error = 1;
      } elseif(empty($_POST['server-database-name'])) {
        $error = 1;
      } elseif(empty($_POST['server-database-user-name'])) {
        $error = 1;
      } elseif(empty($_POST['server-database-user-pass'])) {
        $error = 1;
      } elseif(empty($_POST['server-admin-pass-1'])) {
        $error = 1;
      } elseif(empty($_POST['server-admin-pass-2'])) {
        $error = 1;
      } else {
        
        if($_POST['server-admin-pass-1'] != $_POST['server-admin-pass-2']) {
            $error = 1;
            $msg = "password not matchs.";
        }
        
      }
      
      if($error == 0) {
       # make the folder if not exists
        if (!file_exists('res/server-config/')) {
          mkdir('res/server-config/', 0777, true);
        }
        
        # create and open file of config this server
        $file = fopen("res/server-config/server-config.php","a+");
      
        # pre file
        $pre_file = "";
        
        $server_database_host = $_POST['server-database-host'];
        $server_database_port = $_POST['server-database-port'];
        $server_database_name = $_POST['server-database-name'];
        $server_database_user = $_POST['server-database-user-name'];
        $server_database_pass = $_POST['server-database-user-pass'];
        $server_admin_pass = $_POST['server-admin-pass-1'];
        
        $key = "version2.7PMSConnectorANdIMS";
        $key = crypt("$key", $crypt_salt);
        $key = strtr($key,"\$","cif");
        
        $pre_file = "
                    <?php
                    # file of server config
                    
                    # server database host
                      \$server_database_host = \"$server_database_host\";
					  
                    # server database port
                      \$server_database_port = \"$server_database_port\";
                      
                    # server database name
                      \$server_database_name = \"$server_database_name\";
                      
                    # server database user
                      \$server_database_user = \"$server_database_user\";
                      
                    # server database pass
                      \$server_database_pass = \"$server_database_pass\";
                      
                    # server admin pass
                      \$server_admin_pass = \"$server_admin_pass\";
                    
                    # security app key
                      \$server_app_security_key = \"$key\";
                    ";
                    
        fwrite($file, $pre_file);
        fclose($file);

        echo "<script>href.location='login.php';</script>";
        
      } else {
        
        die("$msg");
        
      }
    
    }
    
} else {
    
    header("location: main.php");
    
}


?>
<!DOCTYPE html>
    <html>
        <head>
            <title> Indie Server Manager configure </title>
            
            <!-- javascript and style/css -->
            
             <script src='base/js/jquery.js'></script>
             <script src='base/js/editor-propertys.js'></script>
             <script src='res/set-panel.js'></script>
             <link href='base/style/normalize.css' rel='stylesheet' />
             <link href='base/style/editor-propertys.css' rel='stylesheet' />
             
             
        </head>
        <body>
            &nbsp;
            <div id='box-server-initial-configuration'>
                
                <span class='text-title-1'>
                   Indie Server Manager configure
                </span>
            </div>
            &nbsp;</br>
            <div id='box-server-initial-configuration'>
                Informe alguns dados  para começar a usar o Indie Server Manager.
            </div>
            &nbsp;</br>
            <div id='box-server-initial-configuration'>
                
                <form name='server-initial-configuration' action='index.php' method='post'>
                    <p>MySQL&reg; config</p>
                <table width='100%'>
                    
                    <tr>
                        <td>
                            database host:
                        </td>
                        <td>
                            
                            <input type='text' name='server-database-host' value='localhost'>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            database port:
                        </td>
                        <td>
                            
                            <input type='text' name='server-database-port' value='3306'>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            database name:
                        </td>
                        <td>
                            <input type='text' name='server-database-name' placeholder='example: My_database1'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            database user:
                        </td>
                        <td>
                            <input type='text' name='server-database-user-name' placeholder='example: admin_db'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            database password:
                        </td>
                        <td>
                            <input type='password' name='server-database-user-pass' placeholder='database admin pass'>
                        </td>
                    </tr>
                    
                    <tr>
                       <td><p> Server Admin </p></td>
                       <td></td>
                    </tr>
                    <tr>
                        <td>
                            password:
                        </td>
                        <td>
                            <input type='password' name='server-admin-pass-1'>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            retry password:
                        </td>
                        <td>
                            <input type='password' name='server-admin-pass-2'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            i accept terms <input type='checkbox' name='terms' checked='checked'>
                        </td>
                        <td>
                            <input type='submit' value='continue'>
                        </td>
                    </tr>
                </table>
                </form>
            
            
            </div>
