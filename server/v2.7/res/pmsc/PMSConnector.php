<?php

/*
 * Php mysql connector API to server connections with godot
 * revised version on 30/11/2017 | date of next version 01/01/2018
 * written by jonas wesley, Version 1.7
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
 
 
 class PMSConnection extends PMSCJson {
    
    public function pmsc_connect($host, $user, $pass, $db) {
        
        $_connection = new mysqli($host, $user, $pass, $db);
        
        /* create json to response */
        $_j = new PMSCJson();
        
        /* check connection */
        if(mysqli_connect_errno()) {
            
            /* get error */
            $error = mysqli_connect_error();
            
            /* return json */
            $_j->pmsc_consult("open","0");
            $_j->pmsc_new_json_line("connection","failed","true");
            $_j->pmsc_new_json_line("error","$error","true");
            $_j->pmsc_close_consult();
            
            /* return false if not connected */
            return false;
        
            /* exit */
            exit();
            
        } else {
            
            /* return connection */
            return $_connection;
            
        }
        
    }
    
    public function pmsc_close($_connection) {
        
        /* close connection */
        $_connection->close();
        
    }
    
 }
 
class PMSCQuery extends PMSConnection {
    
    
    public function pmsc_query($connection,$sql)     {
        
        # prepare query-string
        $str = $this->pmsc_query_prepare($sql);
        
        # create object error
        //$_e = new PMSCError();
        
        if( $str == "selec" or $str == "SELEC")  {
        
             $this->pmsc_select($connection,$sql);
        
        }
        
        
        else if( $str == "updat" || $str == "UPDAT")   {
        
             $this->pmsc_update($connection,$sql);
        
        }
        
        else if($str == "inser" || $str == "INSER")  {
        
                    
             $this->pmsc_insert($connection,$sql);
          
        }
        
        else if ($str == "delet" || $str == "DELET") {
            
             # created new json object
             $_j = new PMSCJson();
          
          
             $result = $connection->query($sql) or die("Data not found.");
                    
             if($result == 1)  {
                  
                  $_j->pmsc_consult("open","$result");
                  $_j->pmsc_new_json_line("type","\"insert\"","true");
                  $_j->pmsc_new_json_line("return","\"true\"","true");
                  $_j->pmsc_close_consult();
                  
          } else {
            
                  $_j->pmsc_consult("open","$result");
                  $_j->pmsc_new_json_line("type","\"insert\"","true");
                  $_j->pmsc_new_json_line("return","\"false\"","true");
                  $_j->pmsc_close_consult();
            
          }
            
        }
     }
     
     public function pmsc_insert($connection,$sql) {
        
             # created new json object
             $_j = new PMSCJson();
          
          
             $result = $connection->query($sql) or die("Data not found.");
                    
             if($result == 1)  {
                  
                  $_j->pmsc_consult("open","$result");
                  $_j->pmsc_new_json_line("type","\"insert\"","true");
                  $_j->pmsc_new_json_line("return","\"true\"","true");
                  $_j->pmsc_close_consult();
                  
          } else {
            
                  $_j->pmsc_consult("open","$result");
                  $_j->pmsc_new_json_line("type","\"insert\"","true");
                  $_j->pmsc_new_json_line("return","\"false\"","true");
                  $_j->pmsc_close_consult();
            
          }
        
     }
     
     public function pmsc_update($connection,$sql) {
        
        # created new json object
        $_j = new PMSCJson();
        
        $result = $connection->query($sql) or die("Data not found.");
                
        if($result == true) 
          {

                  $_j->pmsc_consult("open","1");
                  $_j->pmsc_new_json_line("type","\"update\"","true");
                  $_j->pmsc_new_json_line("return","\"true\"","true");
                  $_j->pmsc_close_consult();
          } else {
                  $_j->pmsc_consult("open","1");
                  $_j->pmsc_new_json_line("type","\"update\"","true");
                  $_j->pmsc_new_json_line("return","\"false\"","true");
                  $_j->pmsc_close_consult();
          }
        
     }
     
     public function pmsc_select($connection,$sql) {
        
        # created new json object
        $_j = new PMSCJson();
        
        # mysqli query
        $result = $connection->query($sql) or die("Data not found.");
        
        # get rows
        $rows = mysqli_num_rows($result);
        
        # a consulta retornou algo
        if ($rows > 0) {
            
            $d = $result->fetch_array(MYSQLI_ASSOC);
            
        } else {
            
            $_j->pmsc_consult("open","0");
            $_j->pmsc_close_consult();
            
        }
        
        # if result multiples lines
        if($rows > 1 and isset($d)) {
            
            $_j->pmsc_consult("open","$rows");
            
           for($i=0;$i<$rows;$i++)
           {
             $row = $result->fetch_array(MYSQLI_ASSOC);
             $j = json_encode($row);

             $_j->pmsc_new_json_line("$i","$j","true");
        
           }

             $_j->pmsc_consult("close","0");
        }
          
          else {
            
                 $_j->pmsc_consult("open","$rows");
                 
                 /* prepare json */
                 $j = json_encode($d);
                 
                 $_j->pmsc_new_json_line("result","$j","true");
                 $_j->pmsc_consult("close","0");
          }
        
          
     }
     
     public function pmsc_query_prepare($query) 
     {
     
        $query = addslashes($query);
        
        if(strlen($query) > 6)
        {
          $new_string = substr($query,0,5);
          
          return $new_string;
         
        }
        
     
     }
     


}
 
 
 
class PMSCJson  {
    
    
   const OPEN = 'open';
   const BODY = 'body';
   const CLOSE = 'close';
   
   public $log;
    
    
    public function pmsc_consult($mode,$rows) {
        
        
        if ($mode==self::OPEN) {
            
        echo "
             {
                \"consult\": {
                    \"rows\":\"$rows\",
            ";
            
        $this->log = "[OPEN_OK]";
        
        } elseif($mode==self::BODY) { # use pmsc_new_json_line()
            
            echo "
                  \"$key\":$value,
                 
                 ";
            
        } elseif($mode==self::CLOSE) {
            
            $this->log .=  ", [BODY_OK], [CLOSED_OK].";
            
            echo "
                  \"log\":\"$this->log\"
                   }
                 }
                 ";
            
        }
        
        
   }
   
   public function pmsc_close_consult() {
            
            $this->log .=  ", [BODY_OK], [CLOSED_OK].";
            
            echo "
                  \"log\":\"$this->log\"
                   }
                 }
                 ";
   }
   
   public function pmsc_new_json($key,$value) {
    
    $json = "
            {
                \"$key\":\"$value\"
            }
            ";
            
    return $json;
    
   }
   
   public function pmsc_new_json_line($key,$value,$print) {
    
    $json = "
            \"$key\":$value,
            ";
            
    if($print == "true"){
        
        echo $json;
        
    } else {
        
        return $json;
    
           }
    
   }
    public function pmsc_new_json_line_($key,$value) {
    
    $json = "
            \"$key\":\"$value\"
            ";
            
    return $json;
    
   }
   
   public function add_as($string) { # use with pmsc_new_json_line
    
    $string = "\"$string\"";
    
    return $string;
    
   }
} 

class PMSConnectorError extends Exception {}
class PMSCQueryError extends Exception {}
class PMSCJsonError extends Exception {}
