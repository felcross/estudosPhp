<?php

namespace Controller;


class Teste {


   public function view(array $get, string $rota): void {
    
      include $_SERVER['DOCUMENT_ROOT'] . "/Project/Src/View/Page/$rota";
      
   }

}