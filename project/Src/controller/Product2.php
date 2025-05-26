<?php

namespace src\controller;


use Core\View;
use model\ProdutoApi2;
use utils\Erros;
use utils\Sanitizantes;
use Exception;

// Controller



class Product2
{
    private $produtosService;

    public function __construct()
    {
        $this->produtosService = new ProdutoApi2();
    }

    public function buscar()
    {
        // Capturar parâmetros da URL
        $termo = $_GET['termo'] ?? '';
        $pagina = max(0, intval($_GET['pagina'] ?? 0)); // Garantir que não seja negativo
        $limite = intval($_GET['limite'] ?? 10); // Padrão de 10 produtos por página

        $produtos = [];
        $paginacao = [];
        
        // Se há termo de busca, realizar a busca paginada
        if (!empty($termo)) {
            $resultado = $this->produtosService->buscarTodosProdutos($termo ,buscaParcial: true,limite: $limite,pagina: $pagina);
            
            $produtos = $resultado['produtos'];
            $paginacao = [
                'totalPaginas' => $resultado['totalPaginas'],
                'paginaAtual' => $resultado['paginaAtual'],
                'temProxima' => $resultado['temProxima'],
                'totalResultados' => $resultado['totalResultados'],
                'limite' => $resultado['limite']
            ];
        }

         View::render('page/teste2.html.php', [
         'produtos' => $produtos,
         'termo' => $termo,
         'paginacao' => $paginacao
    ]);
}
  

    // Método para AJAX - retorna apenas os dados
    public function buscarAjax()
    {
        header('Content-Type: application/json');
        
        $termo = $_GET['termo'] ?? '';
        $pagina = max(0, intval($_GET['pagina'] ?? 0));
        $limite = intval($_GET['limite'] ?? 10);
        
        if (empty($termo)) {
            echo json_encode([
                'produtos' => [],
                'paginacao' => [
                    'totalPaginas' => 0,
                    'paginaAtual' => 0,
                    'temProxima' => false,
                    'totalResultados' => 0
                ]
            ]);
            return;
        }
        
        $resultado = $this->produtosService->buscarTodosProdutos($termo, buscaParcial: true, limite: $limite,pagina: $pagina);
        
        echo json_encode([
            'produtos' => $resultado['produtos'],
            'paginacao' => [
                'totalPaginas' => $resultado['totalPaginas'],
                'paginaAtual' => $resultado['paginaAtual'],
                'temProxima' => $resultado['temProxima'],
                'totalResultados' => $resultado['totalResultados'],
                'limite' => $resultado['limite']
            ]
        ]);
    }
}



$productController = new Product2();
$productController->buscar();

















