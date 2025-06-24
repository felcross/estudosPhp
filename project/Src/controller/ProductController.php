<?php

namespace controller;


use Core\View;
use model\ProdutoApi;
use utils\Erros;
use utils\Sanitizantes;
use Exception;
use FrontController;
use utils\Tokens;
use SessionManager;


// Controller

class ProductController extends PageControl
{
    private $produtoApi;


    public function __construct()
    {
        $this->produtoApi = new ProdutoApi();
      SessionManager::isLoggedIn() || (header('Location: 404.html.php') && exit);

    }

    public function processarAtualizacaoAjax()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['PUT'])) {
            header('Content-Type: application/json');


             // ← VALIDAÇÃO CSRF
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (!SessionManager::validateCsrfToken($csrfToken)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Token CSRF inválido'
            ]);
            return;
        }

        

            // O ID do produto vem do input hidden #modalIdProduto com name="id_produto"
            $produtoId =  Sanitizantes::filtro(string: $_POST['produto_id']) ?? null;
           

            // Campos do formulário do modal. As chaves de $_POST correspondem
            // aos 'name' dos inputs no modal e às chaves do formData no JS.
            $codigoBarra = Sanitizantes::filtro($_POST['codigobarra']) ?? null;
            $qtdMaxArmazenagem =   Sanitizantes::filtro($_POST['qtd_max_armazenagem']) ?? null;
            $local =   Sanitizantes::filtro($_POST['local']) ?? null;
            $local2 =  Sanitizantes::filtro($_POST['local2']) ?? null;
            $local3 =   Sanitizantes::filtro($_POST['local3'])?? null;



            if (!$produtoId) {
                echo json_encode(['success' => false, 'message' => 'ID do produto não fornecido para atualização.']);
                exit;
            }

            $dadosParaAtualizar = [];

            if ($codigoBarra !== null) {
                $dadosParaAtualizar['CODIGOBARRA'] = $codigoBarra;
            }
            if ($qtdMaxArmazenagem !== null) {
                $dadosParaAtualizar['QTD_MAX_ARMAZENAGEM'] = (int) $qtdMaxArmazenagem; // Cast para int
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


            if (empty($dadosParaAtualizar)) {
                echo json_encode(['success' => false, 'message' => 'Nenhum dado válido para atualização foi fornecido.']);
                exit;
            }

            // Aqui, $produtoId é o valor de $produto['PRODUTO'] que foi enviado
            $resultado = $this->produtoApi->atualizarProduto($produtoId, $dadosParaAtualizar);

        

            if (isset($resultado['status']) && $resultado['status']) { // Verifique se 'status' existe antes de acessá-lo
                echo json_encode(['success' => true, 'message' => $resultado['mensagem'] ?? 'Produto atualizado com sucesso!', 'data' => $resultado]);
            } else {
                http_response_code(400); // Ou 500, dependendo da natureza do erro
                echo json_encode([
                    'success' => false,
                    'message' => $resultado['mensagem'] ?? 'Falha ao atualizar o produto.',
                    'details' => $resultado['detalhes'] ?? null,
                    'api_status_code' => $resultado['codigo'] ?? null
                ]);
            }
            exit;
        }
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

        View::render('page/search.html.php', [
            'produtos' => $produtos,
            'termo' => $termo,
            'pagina' => $pagina / 25, // Passar a página atual
            'limite' => $limite   // Passar o limite
        ], 'product2');
    }




}





















































