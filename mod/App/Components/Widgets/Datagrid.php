<?php 
namespace Components\Widgets;

use Controller\ActionInterface;
use Components\Widgets\DatagridColumn;


class Datagrid  {

   private  $columms;
   private  $actions;
   private  $items;

         public function __construct()
         {    
              $this->columms = [];
              $this->actions = [];
              $this->items = [];
            
         }


     public function addColumn(DatagridColumn $object) {

        $this->columms[] = $object;
     }

     public function addAction($label, ActionInterface $action,$field, $image = null ) {

        $this->actions = ['label' => $label,'action' => $action , 'field' => $field , 'image' => $image];
     }

     public function addItem($object) {

        $this->items[] = $object;
     }


     public function getColumns() {

         return $this->columms;
     }

     public function getActions() {

        return $this->actions;
     }

     public function getItems() {

        return $this->items;
     }

     public function clear() {

        $this->items = [];
     }



     
   
      


}