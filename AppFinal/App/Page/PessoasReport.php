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
class PessoasReport extends PageControl
{
    /**
     * método construtor
     */
    public function __construct()
    {
        parent::__construct();

        $loader = new FilesystemLoader('Resources');
	    $twig = new Environment($loader);

        // vetor de parâmetros para o template
        $replaces = array();
        
        try
        {
            // inicia transação com o banco 'livro'
            Transaction::open('configLoja');
            $repository = new Repository('view_saldo_pessoa');
            $replaces['pessoas'] = $repository->all();;
            Transaction::close(); // finaliza a transação

            $content = $twig->render('pessoas_report.html', $replaces);
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
            Transaction::rollback();
        }
        
      //  $content = $twig->render('pessoas_report.html', $replaces);
        //$options = new Options();
       // $options->set('dpi', 128);

        $dompdf = new Dompdf();
       // $options = $dompdf->getOptions();
        $dompdf->loadHtml('C:\Apache24\htdocs\AppFinal\App\Page\PessoasReport.php');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();


        $filename = $_SERVER['DOCUMENT_ROOT'] . '/AppFinal/App/conta.pdf';
        file_put_contents($filename, $dompdf->output());
        echo "<script> window.open('{$filename}')  </script>";


       /* $filename = $_SERVER['DOCUMENT_ROOT'] . '/AppFinal/App/conta.pdf';
      if(is_writable($filename)) 
           {

        file_put_contents($filename, $dompdf->output());
        echo "<script> window.open('{$filename}')  </script>";

            } 
            else 
            {

                 new Message('error', 'Não tem permissão');
            }*/


        

        // cria um painél para conter o formulário
        $container = new Container('Pessoas');
        $container->style = 'align:center;
        margin:50px;
        padding-left:0';
        $container->add($content);
        
        parent::add($container);
    }
}
