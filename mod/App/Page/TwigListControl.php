<?php
namespace Page;
require_once '/Apache24/htdocs/mod/App/vendor/autoload.php';

use Components\Nav;
use Components\SimpleForm;
use Controller\PageControl;
use Twig\Attribute\FirstClassTwigCallableReady;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigListControl extends PageControl {

    

   public function __construct()
   {
        parent::__construct();
        $loader = new FilesystemLoader('Templates');
        $twig = new Environment($loader);
        //$template = $twig->load('Navbar.html');
        $template2 = $twig->load('list.html');
         
        

        $replaces = [];
        $replaces['Home'] = 'Home';
        $replaces['Sobre'] = 'Sobre';
        $replaces['Serviços'] = 'Serviços';
        $replaces['Contato'] = 'Contato';

        $registros['pessoas'] = [
            [
                'codigo' => 1,
                'nome' => 'João Silva',
                'endereco' => 'Rua das Flores, 123'
            ],
            [
                'codigo' => 2,
                'nome' => 'Maria Oliveira',
                'endereco' => 'Avenida Brasil, 456'
            ],
            [
                'codigo' => 3,
                'nome' => 'Carlos Souza',
                'endereco' => 'Praça da Liberdade, 789'
            ]
        ];
        
        //$replaces['action'] = '?class=\page\TwigControl&method=onGravar';

       // print $template->render($replaces);
        print $template2->render($registros);


    
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