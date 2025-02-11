<?php
namespace Page;
require_once '/Apache24/htdocs/mod/App/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Controller\PageControl;
use Components\Container\Container;

use Components\Dialog\Message;
use Database\Transaction;
use Database\Repository;

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
        }
        catch (Exception $e)
        {
            new Message('error', $e->getMessage());
            Transaction::rollback();
        }
        
        $content = $twig->render('pessoas_report.html', $replaces);
        
        // cria um painél para conter o formulário
        $container = new Container('Pessoas');
        $container->style = 'align:center;
        margin:50px;
        padding-left:0';
        $container->add($content);
        
        parent::add($container);
    }
}
