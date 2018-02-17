<?php

class PMSCEmail {
    
    public function pmsc_send_mail($to, $subject, $msg, $from, $title) {
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: $title <$from>";
        
        $msg = "
               <html>
               <head>
               <style type='text/css'>
               /*
                *
                * Style for template 1 of pmsc mail
                * witten by jonas wesley
                *
                */
               
               #header {
                   position: relative;
                   width: 100%;
                   font:12pt Helvetica;
                   color:skyBlue;
                   background-color: #000;
                   padding:5px;
               } #main {
                   position: relative;
                   width: 100%;
                   font:10pt Helvetica;
                   color:#000;
                   background-color: #fff;
                   padding:4px;
                   border: 1px solid #000;
               }
               </style>
               </head>
               <body>
               
               <div id='header'>
               $title
               </div>
               <div id='main'>
               $msg
               </div>
               </body>
               ";
        
       $result =  mail($to, $subject, $msg, $headers);
        
       return $result;
    }
    
    
}

