<?php
namespace Page;
require_once '/Apache24/htdocs/mod/App/vendor/autoload.php';

use Components\Nav;
use Components\SimpleForm;
use Controller\PageControl;
use Twig\Attribute\FirstClassTwigCallableReady;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigControl2 extends PageControl {

    

   public function __construct()
   {
        parent::__construct();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
        $template = $twig->load('Navbar.html');
        $template2 = $twig->load('welcome.html');
         
        

        $replaces = [];
        $replaces['Home'] = 'Home';
        $replaces['Sobre'] = 'Sobre';
        $replaces['Serviços'] = 'Serviços';
        $replaces['Contato'] = 'Contato';

        $replaces2 = [];
        $replaces2['nome'] = 'maria';
        $replaces2['rua'] = 'das flores';
        $replaces2['cep'] = '252514125';
        $replaces2['fone'] = '21 6565656';
        //$replaces['action'] = '?class=\page\TwigControl&method=onGravar';

        print $template->render($replaces);
        print $template2->render($replaces2);


    
        //print $template->display($replaces);

      // print $twig->render('form.html',$replaces);

       
   } 


   public function onGravar($param)
    {
        echo 'Resultado da ação 2';
        echo $param['Contato'];
        echo $param['Sobre'];
        
    }

}