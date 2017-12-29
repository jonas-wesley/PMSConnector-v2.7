<?php

class FileManager {
    
    const WRITE = 'write';
    const READ = 'read';
    const DELETE = 'delete';
    
    public function pmsc_fwrite($file,$content,$mode) {
        
             $file_ = $file;
             $file = fopen($file_,$mode);
     
             fwrite($file,$content);
             fclose($file);
             
             if(file_exists($file_)) {
               $response = "success, $file_ has created";
             } else {
               $response = "failed";
             }
             
             $_j = new PMSCJson();
             $response = $_j->add_as($response);
             $_j->pmsc_consult("open","0");
             $_j->pmsc_new_json_line("server_response","$response","true");
             $_j->pmsc_close_consult();
    }
    
    public function pmsc_fread($file,$mode) {
        
        if(file_exists($file)) {
            
            $fread = file_get_contents($file);
            
            
             $_j = new PMSCJson();
             $response = $_j->add_as($fread);
             $_j->pmsc_consult("open","0");
             $_j->pmsc_new_json_line("file_content","$response","true");
             $_j->pmsc_close_consult();
             
             
        } else {
             
             $response = "failed, file no exist";
             $_j = new PMSCJson();
             $response = $_j->add_as($response);
             $_j->pmsc_consult("open","404");
             $_j->pmsc_new_json_line("file_content","$response","true");
             $_j->pmsc_close_consult();
        }
        
    }
    
}
