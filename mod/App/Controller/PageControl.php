<?php 
namespace Controller;

class PageControl {


    public function show() {

          if($_GET) 
          {
              $method = isset($_GET['method']) ? $_GET['method'] : null;
                     
                  if(method_exists($this,$method)){
                      
                       call_user_func([$this,$method],$_GET );
                  }
                 
          }
    }

}