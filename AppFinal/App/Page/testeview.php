<?php
namespace Page;

use Controller\PageControl;
use Database\Repository;
use Database\Transaction;

class testeview  extends PageControl
{

    public function __construct()
    {
         parent::__construct();
         Transaction::open('configLoja');
          
          $repository = new Repository('view_saldo_pessoa');
          $all = $repository->all();
          Transaction::close();

          var_dump($all);
    }


}
