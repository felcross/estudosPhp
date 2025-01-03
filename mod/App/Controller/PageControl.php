<?php 
namespace Controller;

use Components\Base\Element;

class PageControl  extends Element {

    public function __construct()
    {
        parent::__construct('div');

        echo 'estou estagio 3';
    }


    public function show() {

          if($_GET) 
          {
              $method = isset($_GET['method']) ? $_GET['method'] : null;
                     
                  if(method_exists($this,$method)){
                      
                       call_user_func([$this,$method],$_REQUEST );
                  }
                 
          }

          parent::show();

    }

}