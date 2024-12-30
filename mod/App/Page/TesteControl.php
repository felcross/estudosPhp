<?php
namespace Page;

use Components\Element;
use Controller\PageControl;

class TesteControl extends PageControl
 {  
     public function __construct()
     {    
        parent::__construct();

        $div = new Element('div');
        $div->style = 'text-align:center;';
        $div->style .= 'font-weight:bold;';
        $div->style .= 'font-size:14pt;';
        $div->style .= 'margin:20px;';
        $div->style .= 'background-color: green;';
         $p = new Element('p');
         $p2 = new Element('p');
         $div->add($p);
         $div->add($p2);
         $p->add('Aqui tem html');
         $p2->add('Aqui tem html2');
         //$div->show();
         parent::add($div);
     }

     public function onGravar($param)
     {
         var_dump($param);
         
     }
   


 }