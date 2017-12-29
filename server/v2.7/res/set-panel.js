$(document).ready(function() {
  
   $("#db_manager").click(function() {
   
     $("#box-editor-panel").load("res/db_manager.php");
   
   });
   
   $("#email_templates").click(function() {
      
      $("#box-editor-panel").load("res/config_email_templates.php");
      
      });
    
   $("#connect_fb_page").click(function() {
      
      $("#box-editor-panel").load("res/connect_fb_page.php");
      
   });

});