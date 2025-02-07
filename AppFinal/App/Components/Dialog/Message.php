<?php
namespace Components\Dialog;

use Components\Base\Element;

class Message {

   public function __construct($type,$message)
   {
      $div = new Element('div');
      if($type == 'info'){
        $div->class = 'alert alert-info';
        $div->role = 'alert';
      }
      else if($type == 'error'){
        $div->class = 'alert alert-danger';
        $div->role = 'alert';
      }

      $div->add($message);
      $div->show();
   }

}