$(document).ready(function () {
    
    $(document).on("click","button[login]", function (e) {

        e.preventDefault()
        //REQ
        $.post("./system/app/controller/login.php", {
            user: $('#user').val(),
            pass: $('#pass').val()
            
        },
            function (data) {
              console.log(data)  
              if(data == 1) 
             location.href = '?p=error'  
              if(data == 0) 
             location.href = '?p=login'  
         
             
            
            

            }
            
        );

    })
});