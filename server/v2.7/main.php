<?php
/*
 *
 * Indie Server Manager written by Jonas Wesley
 *
 */
session_start();
if(!isset($_SESSION['user_pass'])) {
    header("location: login.php");
} else {
if(file_exists("res/server-config/server-config.php")) {
    include("res/server-config/server-config.php");
} else {
    die("configure the server.");
    }
}



?>

<!DOCTYPE html>
    <html>
        <head>
            <title> Indie Server Manager </title>
            
            <!-- javascript and style/css -->
            
             <script src='base/js/jquery.js'></script>
             <script src='base/js/editor-propertys.js'></script>
             <script src='res/set-panel.js'></script>
             <link href='base/style/normalize.css' rel='stylesheet' />
             <link href='base/style/editor-propertys.css' rel='stylesheet' />
             
             
        </head>
        <body>
            &nbsp;<br/>
            <table width='100%'>
                <tr>
                    <td width='20%'>
                        
                        <div id='box-editor-menu'>
                          <span class='box-editor-link' id='connect_fb_page'>
                            connect fb page
                          </span>
                          
                          <span class='box-editor-link'>
                            <span onclick="alert('<?php echo $server_app_security_key ?>')">view security key</span>
                          </span>
                        </div>
                        
                    </td>
                    <td width='5%'>
                        
                    </td>
                    <td width='30%'>
                        <div id='box-editor-menu'>
                          <span class='box-editor-link' id='db_manager'>
                            database manager
                          </span>
                          
                         <!-- <span class='box-editor-link' id='generate_content'>
                            manager website
                          </span>
                          <span class='box-editor-link' id='email_templates'>
                            email templates
                          </span>-->
                        </div>
                    </td>
                    <td width='35%'>
                        
                    </td>
                    <td>
                        <div id='box-editor-menu'>
                          <span class='box-editor-link' id=''>
                            settings
                          </span>
                          <span class='box-editor-link' id='' onclick="top.location.href='logout.php'">
                            logout
                          </span>
                        </div>
                    </td>
                </tr>
            </table>
            
            
            
            <table width='100%'>
                <tr>
                    <td width='80%'>
                        
                        <div id='box-editor-panel'>
                            
                            
                            
                        </div>
                        
                    </td>
                    <td valign='top'>
                        
                        <div id='box-editor-panel'>
                            
                            Server and ISM informations
                            <p>
                                
                                <table width='100%'>
                                    <tr>
                                        <td class='table-tables'>PMSConnector version</td>
                                        <td class='table-tables'>2.7</td>
                                    </tr>
                                    <tr>
                                        <td class='table-tables'>
                                            ISM version
                                        </td>
                                        <td class='table-tables'>
                                            1.0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='table-tables'>
                                            database manager version
                                        </td>
                                        <td class='table-tables'>
                                            1.0
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='table-tables'>
                                            PHP version
                                        </td>
                                        <td class='table-tables'>
                                            <?php echo phpversion() ?>
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                                
                                
                                
                            </p>
                            <p>
                                <i>Written by Jonas Wesley.</i>
                            </p>
                            
                        </div>
                    </td>
                </tr>
            </table>

            
            
            
        </body>
    </html>