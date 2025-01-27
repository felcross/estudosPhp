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

    

   public function __construct()
   {
        parent::__construct();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
        $template = $twig->load('Welcome.html');
         
        

        $replaces = [];
        $replaces['nome'] = 'maria';
        $replaces['rua'] = 'das flores';
        $replaces['cep'] = '252514125';
        $replaces['fone'] = '21 6565656';
        //$replaces['action'] = '?class=\page\TwigControl&method=onGravar';

        print $template->render($replaces);

    
        //print $template->display($replaces);

      // print $twig->render('form.html',$replaces);

       
   } 


   public function onGravar($param)
    {
        echo 'Resultado da ação';
        echo $param['nome'];
        echo $param['rua'];
        
    }

}