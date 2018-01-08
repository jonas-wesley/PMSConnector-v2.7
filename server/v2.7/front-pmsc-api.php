<?php

/*
 * Php mysql connector API to server connections with godot
 * revised version on 30/11/2017 
 * written by jonas wesley, Version 2.7
 * 
 * "Everything can connect, everything can be connected."
 * 
 * Copyright (C) 2017  Lights On
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License or other latest 
 * version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

# no error messages
  error_reporting(0);
  
 const POST = 'post';
 const GET = 'get';
 
# verify if file exists 
if (!file_exists("res/pmsc/PMSConnector.php")) {
     die("Main file no exist.");
} elseif(!file_exists("res/server-config/server-config.php")) {
     
     die("server not configured.");
     
} else {
    
     include "res/server-config/server-config.php";
     include "res/pmsc/PMSConnector.php";
     
     if(isset($_POST['opt'])) {
        
        $client_opt = $_POST['opt'];
        $client_method = "post";
        $client_app_security_key = $_POST['security_key'];
        
     } else if (isset($_GET['opt'])) {
        
        $client_opt = $_GET['opt'];
        $client_method = "get";
        $client_app_security_key = $_GET['security_key'];
     }
}
    
if($client_app_security_key != $server_app_security_key) {
     
     die("keys error..");
     
}
if(isset($client_opt)) {
    
    if($client_method==POST) {
        
        # get client query
        $query = $_POST['query'];
     
    } else if($client_method==GET) {
        
        # get client query
        $query = $_GET['query'];
        
    }


} else { die("client option not found."); }
    



if ($client_opt == "direct_query") {
     
     $host = $server_database_host;
     $user_con = $server_database_user;
     $pass_con = $server_database_pass;
     $DB = $server_database_name;

      $pmsc = new PMSConnection();
      $_connection = $pmsc->pmsc_connect("$host","$user_con","$pass_con","$DB");
      
      if(!$_connection) {
          
          die("not connected.");
          
      } else {
          
      $pmsc_query = new PMSCQuery();
      $pmsc_query->pmsc_query($_connection,$query);
      
      }
      
} elseif ($client_opt == "server_info") {

     # get server info
     $server = getenv($query);
     
     $_j = new PMSCJson();
     $server = $_j->add_as($server);
     $_j->pmsc_consult("open","0");
     $_j->pmsc_new_json_line("server_response","$server","true");
     $_j->pmsc_close_consult();
     
    } elseif($client_opt=="file_manager") {
     
             if($client_method==POST) {
               
             $file = $_POST['file'];
             $content = $_POST['content'];
             $mode = $_POST['mode'];
             $sub_opt = $_POST['sub_opt'];
             
             } elseif($client_method==GET) {
               
             $file = $_GET['file'];
             $content = $_GET['content'];
             $mode = $_GET['mode'];
             $sub_opt = $_GET['sub_opt'];
             }
             
             include "res/pmsc/FileManager.php";
             
             $fm = new FileManager();
             
             if($sub_opt==$fm::WRITE) {
               
             $fm::pmsc_fwrite($file,$content,$mode);
             
             } elseif($sub_opt==$fm::READ) {
               
               $fm::pmsc_fread($file,$mode);
               
             }
             
     
     }  elseif($client_opt == "math_rand") {
                 
                 if($client_method==POST) {
                    
                 $v1 = $_POST['v1'];
                 $v2 = $_POST['v2'];
                 
                 } elseif($client_method==GET) {
                    
                 $v1 = $_GET['v1'];
                 $v2 = $_GET['v2'];
                 
                 }
                 
                 $r = rand($v1,$v2);
                 
                    $_j = new PMSCJson();
                    $result = $_j->add_as($r);
                    $_j->pmsc_consult("open","0");
                    $_j->pmsc_new_json_line("x","$result","true");
                    $_j->pmsc_close_consult();
                          
          } elseif($client_opt == "send_email") {
               
               include "res/pmsc/MailManager.php";
               
               $email = new PMSCEmail();
               
               if($client_method==POST) {
               
               $to = $_POST['to'];
               $subject = $_POST['subject'];
               $from = $_POST['from'];
               $msg = $_POST['msg'];
               $title = $_POST['title'];
               
               } elseif($client_method==GET) {
                    
               $to = $_GET['to'];
               $subject = $_GET['subject'];
               $from = $_GET['from'];
               $msg = $_GET['msg'];
               $title = $_GET['title'];
                
               }
               $result = $email->pmsc_send_mail($to, $subject, $msg, $from, $title);
               
               if($result) {
                    $_j = new PMSCJson();
                    $_j->pmsc_consult("open","1");
                    $_j->pmsc_new_json_line("mail","\"sent email.\"","true");
                    $_j->pmsc_close_consult();
               } else {
                    
                    $_j = new PMSCJson();
                    $_j->pmsc_consult("open","0");
                    $_j->pmsc_new_json_line("mail","\"error, dont sent email.\"","true");
                    $_j->pmsc_close_consult();
               }
     

     }  elseif($client_opt=="post_fbpage") {
          
          
               include "res/pmsc/SocialMedia.php";
               
               $new_post = new SocialMedia();
               
               if($client_method==POST) {
               
               $link = $_POST['link'];
               $message = $_POST['message'];
               $app = $_POST['app'];

               
               } elseif($client_method==GET) {
                    
               $link = $_GET['link'];
               $message = $_GET['message'];
               $app = $_GET['app'];
                
               }
               
               $data['link'] = $link; #godot server connector GSC
               $data['message'] = $message;
               
               $app = "res/fb-apps/" . $app . ".php";
               include "$app";
               
               
               $r = $new_post->pmsc_post_fbpage($fb_app_token,$fb_app_pageid,$data);
               
               $_j = new PMSCJson();
               $_j->pmsc_consult("open","1");
               $_j->pmsc_new_json_line("post_fbpage","\"$r\"","true");
                $_j->pmsc_new_json_line("post_app","\"$app\"","true");
               $_j->pmsc_close_consult();
               
          
     }
      else {
     
     die();
     
    }
    

