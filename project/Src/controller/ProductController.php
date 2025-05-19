<?php

namespace src\controller;


use Core\View;
use model\ProdutoApi;
use utils\Sanitizantes;
use Exception;

// Controller

class ProdutoController
{
    private $produtoApi;

    public function __construct()
    {
        $this->produtoApi = new ProdutoApi(); // Supondo que ProdutoApi não precise de args ou use defaults
    }

    // Este método agora é chamado primeiro dentro de buscar()
    // e lida exclusivamente com a lógica de atualização via POST AJAX.
    public function processarAtualizacaoAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
            header('Content-Type: application/json'); // Sempre retorne JSON para AJAX

            $produtoId = $_POST['id_produto'] ?? null; // Do input hidden #modalIdProduto

            // Novos campos do formulário do modal (conforme seu JS)
            // As chaves do $_POST devem corresponder aos 'name' dos inputs no modal
            // e ao que o JavaScript está enviando.
            $descricao = $_POST['descricao'] ?? null;
            $codigoBarra = $_POST['CODIGOBARRA'] ?? null; // JS envia 'CODIGOBARRA'
            $qtdMaxArmazenagem = $_POST['QTD_MAX_ARMAZENAGEM'] ?? null; // JS envia 'QTD_MAX_ARMAZENAGEM'
            $local = $_POST['LOCAL'] ?? null; // JS envia 'LOCAL'
            $local2 = $_POST['LOCAL2'] ?? null; // JS envia 'LOCAL2'
            $local3 = $_POST['LOCAL3'] ?? null; // JS envia 'LOCAL3'

            if (!$produtoId) {
                echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido PROD.']);
                exit;
            }

            // Montar o array de dados para atualização
            // As chaves aqui devem corresponder ao que a API Emauto espera.
            // Se a API Emauto espera DESCRICAO, CODIGOBARRA (maiúsculas), mantenha assim.
            $dadosParaAtualizar = [];

            // Adicione apenas os campos que foram enviados e são permitidos para atualização
            if ($descricao !== null) {
                $dadosParaAtualizar['DESCRICAO'] = $descricao; // Ex: se a API espera 'DESCRICAO'
            }
            if ($codigoBarra !== null) {
                $dadosParaAtualizar['CODIGOBARRA'] = $codigoBarra;
            }
            if ($qtdMaxArmazenagem !== null) {
                // O Model fará o (int) cast, mas pode ser bom validar se é numérico aqui
                $dadosParaAtualizar['QTD_MAX_ARMAZENAGEM'] = $qtdMaxArmazenagem;
            }
            if ($local !== null) {
                $dadosParaAtualizar['LOCAL'] = $local;
            }
            if ($local2 !== null) {
                $dadosParaAtualizar['LOCAL2'] = $local2;
            }
            if ($local3 !== null) {
                $dadosParaAtualizar['LOCAL3'] = $local3;
            }

            // Adicione outros campos que sua API Emauto possa aceitar e que venham do form
            // Por exemplo, se 'REFERENCIA' ainda é um campo editável e enviado pelo JS:
            // if (isset($_POST['referencia'])) $dadosParaAtualizar['REFERENCIA'] = $_POST['referencia'];

            if (empty($dadosParaAtualizar)) {
                 echo json_encode(['success' => false, 'message' => 'Nenhum dado válido para atualização foi fornecido.']);
                 exit;
            }


            $resultado = $this->produtoApi->atualizarProduto($produtoId, $dadosParaAtualizar);

            // dd($resultado); // Remova ou comente para produção

            if ($resultado['status']) {
                echo json_encode(['success' => true, 'message' => $resultado['mensagem'], 'data' => $resultado]);
            } else {
                // Para erros, você pode querer enviar um código de status HTTP diferente
                // http_response_code(400); // Bad Request, se for erro de validação do cliente
                // http_response_code(500); // Internal Server Error, se for erro da API Emauto ou do seu sistema
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['mensagem'],
                    'details' => $resultado['detalhes'] ?? null,
                    'api_status_code' => $resultado['codigo'] ?? null
                ]);
            }
            exit; // Crucial: Impede que o restante da renderização da página HTML ocorra
        }
    }

    public function buscar()
    {
        // Chama o método para processar a atualização AJAX PRIMEIRO.
        // Se for uma requisição de atualização, ele fará o 'exit' e não continuará.
        $this->processarAtualizacaoAjax();

        // Fluxo normal de carregamento da página para busca (GET)
        $termo = isset($_GET['termo']) ? Sanitizantes::filtro($_GET['termo']) : ''; // Sanitizar termo de busca
        $produtos = [];

        if (!empty($termo)) {
            // Supondo que buscarTodos lide com a sanitização interna ou que o termo já está seguro
            $produtos = $this->produtoApi->buscarTodos($termo, true, 15); // limite: 15
        }

        // Supondo que 'View' é sua classe para renderizar templates
        // e 'product' é um arquivo JS específico para esta view.
        View::render('page/search2.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
        ], 'product'); // js:'product'
    }
}

// Roteamento básico (geralmente em um arquivo de rotas ou index.php)
 $productController = new ProdutoController();
 $productController->buscar(); // Este método agora lida com POST para atualização ou GET para busca




















































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



























