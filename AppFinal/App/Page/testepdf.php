<?php
namespace Page;
require_once '/Apache24/htdocs/AppFinal/App/vendor/autoload.php';



use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Controller\PageControl;
use Components\Container\Container;

use Components\Dialog\Message;
use Database\Transaction;
use Database\Repository;

use Dompdf\Dompdf;
use Dompdf\Options;

use Exception;


/**
 * Relatório de vendas
 */
class testepdf extends PageControl
{
    /**
     * método construtor
     */
    public function __construct()
    {
        parent::__construct();

        $loader = new FilesystemLoader('Resources');
	    $twig = new Environment($loader);

        $content = $twig->render('pessoas_report.html');


        $dompdf = new Dompdf();
        $dompdf->loadHtml('hello world');
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();

     

       /*
        $filename = $_SERVER['DOCUMENT_ROOT'] . '/AppFinal/App/conta.pdf';
      if(is_writable($filename)) 
           {

        file_put_contents($filename, $dompdf->output());
        echo "<script> window.open('{$filename}')  </script>";

            } 
            else 
            {

                 new Message('error', 'Não tem permissão');
            }

            

*/      $container = new Container('Pessoas');
        $container->style = 'align:center;
        margin:50px;
        padding-left:0';
        $container->add($content);
        
        parent::add($container);
        

       
    }
}
