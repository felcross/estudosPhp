<?php

namespace controller;


use Core\View;
use model\ProdutoApi;
use utils\Erros;
use utils\Sanitizantes;
use Exception;
use FrontController;
use utils\Tokens;


// Controller

class ProductController extends PageControl
{
    private $produtoApi;


    public function __construct()
    {
        $this->produtoApi = new ProdutoApi();
    }

    public function processarAtualizacaoAjax()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
        header('Content-Type: application/json');

        try {
            // Validar e sanitizar dados de entrada
            $produtoId = $this->validarProdutoId($_POST['produto_id'] ?? null);
            $dadosParaAtualizar = $this->processarDadosAtualizacao($_POST);

            if (empty($dadosParaAtualizar)) {
                $this->retornarErro('Nenhum dado válido para atualização foi fornecido.');
                return;
            }

            // Fazer a atualização
            $resultado = $this->produtoApi->atualizarProduto($produtoId, $dadosParaAtualizar);

            // Processar resposta
            $this->processarRespostaApi($resultado);

        } catch (Exception $e) {
            $this->retornarErro('Erro interno: ' . $e->getMessage(), 500);
        }
    }
}

private function validarProdutoId($produtoId): string
{
    if (empty($produtoId)) {
        $this->retornarErro('ID do produto não fornecido para atualização.');
        exit;
    }
    
    return filter_var($produtoId, FILTER_SANITIZE_SPECIAL_CHARS);
}

private function processarDadosAtualizacao(array $post): array
{
    $dadosParaAtualizar = [];
    
    // Mapeamento de campos com suas validações
    $campos = [
        'codigobarra' => 'CODIGOBARRA',
        'local' => 'LOCAL',
        'local2' => 'LOCAL2',
        'local3' => 'LOCAL3'
    ];
    
    foreach ($campos as $inputName => $apiField) {
        if (isset($post[$inputName]) && $post[$inputName] !== '') {
            $valor = filter_var($post[$inputName], FILTER_SANITIZE_SPECIAL_CHARS);
            if (!empty($valor)) {
                $dadosParaAtualizar[$apiField] = $valor;
            }
        }
    }
    
    // Campo especial: quantidade (deve ser inteiro)
    if (isset($post['qtd_max_armazenagem']) && $post['qtd_max_armazenagem'] !== '') {
        $qtd = filter_var($post['qtd_max_armazenagem'], FILTER_VALIDATE_INT);
        if ($qtd !== false && $qtd >= 0) {
            $dadosParaAtualizar['QTD_MAX_ARMAZENAGEM'] = $qtd;
        }
    }
    
    return $dadosParaAtualizar;
}

private function processarRespostaApi(array $resultado): void
{
    if (isset($resultado['status']) && $resultado['status']) {
        echo json_encode([
            'success' => true, 
            'message' => $resultado['mensagem'] ?? 'Produto atualizado com sucesso!',
            'data' => $resultado
        ]);
    } else {
        $this->retornarErro(
            $resultado['mensagem'] ?? 'Falha ao atualizar o produto.',
            400,
            [
                'details' => $resultado['detalhes'] ?? null,
                'api_status_code' => $resultado['codigo'] ?? null
            ]
        );
    }
    exit;
}

private function retornarErro(string $message, int $httpCode = 400, array $extraData = []): void
{
    http_response_code($httpCode);
    
    $response = [
        'success' => false,
        'message' => $message
    ];
    
    if (!empty($extraData)) {
        $response = array_merge($response, $extraData);
    }
    
    echo json_encode($response);
    exit;
}



    public function buscar()
    {

        $this->processarAtualizacaoAjax();

        $termoBruto = isset($_GET['termo']) ? filter_input(INPUT_GET, 'termo', FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $produtos = [];
        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $limite = 25;
        $termo = strtoupper($termoBruto);

        $pagina = (int) $pagina * (int) $limite;

        if (!empty($termo)) {
            $produtos = $this->produtoApi->buscarTodos($termo, true, limite: $limite, pagina: $pagina);
        }

       // dd($produtos);

        View::render('page/teste3.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
            'pagina' => $pagina / 25, // Passar a página atual
            'limite' => $limite   // Passar o limite
        ], 'product2');
    }

  


}




























































// class ProdutoController {
//     private $produtoApi;

//     public function __construct() {
//         $this->produtoApi = new ProdutoApi();
//     }


//      // Fix your controller code:

//      public function  atualizar() 
//      { // Handle AJAX request first

//        // dd('entrouuuuu');

//     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {


//         // Process the AJAX update request
//         $produtoId = $_POST['produto_id'] ?? null;
//         $codigo = $_POST['codigo_produto'] ?? null;
//         $descricao = $_POST['descricao'] ?? null;
//         $referencia = $_POST['referencia'] ?? null;
//         $referencia2 = $_POST['referencia2'] ?? null;
//         $codigoBarra = $_POST['codigobarra'] ?? null;
//         $preco = $_POST['preco'] ?? null;

//         if ($produtoId) {

//             $resultado = $this->produtoApi->atualizarProduto($produtoId, [
//                 'codigo' => $codigo,
//                 'descricao' => $descricao,
//                 'referencia' => $referencia,
//                 'referencia2' => $referencia2,
//                 'codigobarra' => $codigoBarra,
//                 'preco' => $preco

//             ]);

//              dd($resultado);

//             // Return JSON response and exit to prevent rendering the HTML
//             header('Content-Type: application/json');
//             echo json_encode(['success' => true, 'message' => 'Produto atualizado com sucesso PROD']);
//             exit; // Important! This prevents the rest of the page from loading
//         } else {
//             // Return error response
//             header('Content-Type: application/json');
//             echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido']);
//             exit;
//         }
//     } }

// public function buscar()
// {
//        $this->atualizar();


//     // Normal page load flow continues here
//     $termo = $_GET['termo'] ?? '';
//     $produtos = [];

//     if (!empty($termo)) {
//         $produtos = $this->produtoApi->buscarTodos($termo, true, limite: 15);
//     }

//     View::render('page/search2.html.php', [
//         'produtos' => $produtos,
//         'termo' => $termo,
//     ],js:'product');
// }







// }


// $productController = new ProdutoController;
// $productController->buscar();



















































// class ProdutoController {
//     private $produtoApi;

//     public function __construct() {
//         $this->produtoApi = new ProdutoApi();
//     }

//     public function buscar() {
//         $termo = $_POST['termo'] ?? '';
//       //  $buscaParcial = isset($_POST['parcial']) ? (bool)$_POST['parcial'] : true;

//         $produtos = [];
//         if (!empty($termo)) {
//             $produtos = $this->produtoApi->buscarTodos($termo, true, limite:15);
//         }

//         View::render('page/search2.html.php', [
//             'produtos' => $produtos,
//             'termo' => $termo,
//          //   'buscaParcial' => $buscaParcial
//         ]);
//     }}





// $productController = new ProdutoController;
// $productController->buscar();



























