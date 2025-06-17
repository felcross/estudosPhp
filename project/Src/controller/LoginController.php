<?php

namespace controller;


use Core\View;
use model\ProdutoApi;
use utils\Erros;
use utils\Sanitizantes;
use Exception;
use FrontController;
use utils\Tokens;
use api\RequestChavesEmauto;
use AuthMiddleware;



class LoginController extends PageControl
{
    private $login;

    public function __construct()
    {
        $this->login = new RequestChavesEmauto();
    }

    public function login()
    {
        // Renderiza a página de login usando componentes
        View::render('page/login.html.php', [
            'title' => 'Login - Sistema'
        ], 'login');
    }

    public function processLogin()
    {


        // Define sempre como JSON response
        header('Content-Type: application/json');

        try {
            // Lê os dados JSON do corpo da requisição
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            // Se não conseguiu decodificar JSON, tenta $_POST (fallback)
            if (!$data) {
                $data = $_POST;
            }
            if (!Tokens::verificaTokenCSRF($data['token'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Usuário e senha são obrigatórios!'
                ]);
                return;
            }

            $user = $data['usuario'] ?? '';
            $pass = $data['senha'] ?? '';
            $redirectClass = $data['redirectClass'] ?? 'ProductController';
            $redirectMethod = $data['redirectMethod'] ?? 'buscar';

            if (empty($user) || empty($pass)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Usuário e senha são obrigatórios!'
                ]);
                return;
            }

            // Processa o login
            $loginResult = $this->login->processaLogin([$user, $pass]);

            if ($loginResult) {
                // Login bem-sucedido
                echo json_encode([
                    'success' => true,
                    'message' => 'Login realizado com sucesso!',
                    'redirectClass' => $redirectClass,
                    'redirectMethod' => $redirectMethod
                ]);
            } else {
                // Login falhou
                echo json_encode([
                    'success' => false,
                    'message' => 'Usuário ou senha inválidos!'
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Erro interno do servidor!',
                'error' => $e->getMessage() // Apenas para debug, remova em produção
            ]);
        }
    }

    public function forgotPassword()
    {
        // Define sempre como JSON response
        header('Content-Type: application/json');

        try {
            // Lê os dados JSON do corpo da requisição
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $email = $data['email'] ?? '';

            if (empty($email)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email é obrigatório!'
                ]);
                return;
            }

            // Validação básica de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email inválido!'
                ]);
                return;
            }

            // Aqui você implementaria a lógica de recuperação de senha
            // Por enquanto, simulando sucesso
            $resetResult = $this->sendPasswordReset($email);

            if ($resetResult) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Nova senha enviada para seu email!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email não encontrado no sistema!'
                ]);
            }

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Erro interno do servidor!'
            ]);
        }
    }

    private function sendPasswordReset($email)
    {
        // Implementar lógica de recuperação de senha
        // Por enquanto retorna true para teste
        return true;
    }
}




























// class LoginController extends PageControl
// {



//      private $login;



//     public function __construct()
//     {
//         $this->login = new RequestChavesEmauto();
//     }



//    public function login()
//     {
//      print_r( $_POST);

//         // Renderiza a página de login usando componentes
//         View::render('page/login.html.php', [
//             'title' => 'Login - Sistema'
//         ], '');
//     }



// public function processLogin()
// {
//     // Verifica se a requisição é AJAX
//     $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

//     try {
//         $user = $_POST['usuario'] ?? '';
//         $pass = $_POST['senha'] ?? '';

//         if (empty($user) || empty($pass)) {
//             if ($isAjax) {
//                 header('Content-Type: application/json');
//                 echo json_encode(['success' => false, 'message' => 'Usuário e senha são obrigatórios!']);
//             } else {
//                 // Redireciona de volta para a página de login com uma mensagem de erro (se o sistema suportar)
//                 header('Location: index.php?class=LoginController&method=login&error=1');
//             }
//             return;
//         }

//         // Processa o login
//         $loginResult = $this->login->processaLogin([$user, $pass]);

//         if ($loginResult) {
//             // Login bem-sucedido
//             if ($isAjax) {
//                 header('Content-Type: application/json');
//                 echo json_encode([
//                     'success' => true,
//                     'message' => 'Login realizado com sucesso!',
//                     'class'   => $_POST['class'] ?? 'ProductController',
//                     'method'  => $_POST['method'] ?? 'buscar'
//                 ]);
//             } else {
//                 // Redirecionamento padrão se não for AJAX
//                 $class = $_POST['class'] ?? 'ProductController';
//                 $method = $_POST['method'] ?? 'buscar';
//                 header("Location: index.php?class={$class}&method={$method}");
//                 exit(); // É crucial chamar exit() após um redirecionamento de header
//             }
//         } else {
//             // Login falhou
//             if ($isAjax) {
//                 header('Content-Type: application/json');
//                 echo json_encode(['success' => false, 'message' => 'Usuário ou senha inválidos!']);
//             } else {
//                 header('Location: index.php?class=LoginController&method=login&error=2');
//             }
//         }

//     } catch (Exception $e) {
//         if ($isAjax) {
//             header('Content-Type: application/json');
//             echo json_encode(['success' => false, 'message' => 'Erro interno do servidor!']);
//         } else {
//             header('Location: index.php?class=LoginController&method=login&error=3');
//         }
//     }
// }

// }




























































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



























