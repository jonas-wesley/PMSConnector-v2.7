<script>
    $(function() {
    
    
      $("#add_app").click(function() {
        
          var fb_app_name = $("input[name=app_name]").val();
          var fb_app_token = $("input[name=app_token]").val();
          var fb_app_pageid = $("input[name=app_page_id]").val();
          
          var _url = "res/connect_fb_page_responses.php?fb_app_name=" + fb_app_name + "&fb_app_token=" + fb_app_token + "&fb_app_pageid=" + fb_app_pageid;
          
          $("#response").load(_url);
         
        
      });
    
     
    });
</script>
<table>
    <tr>
        <td>
            Facebook APP name:
        </td>
        <td>
            <input type='text' name='app_name' placeholder='app name'>
        </td>
    </tr>
    <tr>
        <td>
            Facebook APP token ID:
        </td>
        <td>
            <input type='text' name='app_token' placeholder='app token'>
        </td>
    </tr>
    <tr>
        <td>
            Facebook page ID:
        </td>
        <td>
            <input type='text' name='app_page_id' placeholder='page id'>
        </td>
    </tr>
    <tr>
        <td> &nbsp; </td>
        <td>
            <button id='add_app'> add app</button>
        </td>
    </tr>
</table>

<div id='response'>
&nbsp;
</div>