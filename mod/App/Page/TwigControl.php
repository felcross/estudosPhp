<?php
namespace Page;
require_once '/Apache24/htdocs/mod/App/vendor/autoload.php';

use Components\Nav;
use Components\SimpleForm;
use Controller\PageControl;
use Twig\Attribute\FirstClassTwigCallableReady;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigControl extends PageControl{

   public function __construct()
   {
        //$loader = new FirstClassTwigCallableReady();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
        $template = $twig->load('form.html');

        $replaces =[];
        $replaces['nome'] = 'Deu bom';
        $replaces['Password'] = 'Deu bom 2';
        $replaces['action'] = 'index.php?class=\Page\TwigControl&method=onGravar';

        print $template->render($replaces);

       
   } 


   public function onGravar($param)
    {
        var_dump($param);
    }

}