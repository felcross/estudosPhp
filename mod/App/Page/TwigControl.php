<?php
namespace Page;
require_once '/Apache24/htdocs/mod/App/vendor/autoload.php';

use Components\Nav;
use Components\SimpleForm;
use Controller\PageControl;
use Twig\Attribute\FirstClassTwigCallableReady;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigControl extends PageControl {

    public $param2 = array();

   public function __construct()
   {
        //$loader = new FirstClassTwigCallableReady();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
       $template = $twig->load('form.html');
         
        $response = array();

        $replaces = array();
        $replaces['nome'] = 'maria';
        $replaces['Password'] = '225566';
        $replaces['action'] = '?class=\page\TwigControl&method=onGravar';

        print $template->render($replaces);

    
        //print $template->display($replaces);

      // print $twig->render('form.html',$replaces);

       
   } 


   public function onGravar($param)
    {
        var_dump($param);
        
    }

}