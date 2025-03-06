<?php

  namespace app\Controller;
  use app\controller\Controller;

  class HomeController{
    
    public function index($params){
      var_dump($params);
      return Controller::view('home');
    }

  }