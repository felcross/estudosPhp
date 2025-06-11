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

class LoginController
{


    private $login;

    public function __construct()
    {
        // Inicializa a classe de login
        $this->login = new RequestChavesEmauto();
        
        // Verifica se o usuário já está logado
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // Redireciona para o dashboard se já estiver logado
            header('Location: /dashboard');
            exit();
        }
    }

    public function login()
    {
        // Se já está logado, redireciona para dashboard
        
        AuthMiddleware::requireGuest();

        // Processa o login se houver dados POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_POST['usuario'] ?? '';
            $pass = $_POST['senha'] ?? '';

            if (!empty($user) && !empty($pass)) {
                $loginResult = $this->login->processaLogin([$user, $pass]);
                
                // Se login for bem-sucedido
                if ($loginResult === true) {
                    // Define sessão do usuário
                    $_SESSION['user'] = $user;
                    $_SESSION['logged_in'] = true;
                    $_SESSION['login_time'] = time();
                    
                    // Nota: $_SESSION['chaveEMAUTO'] já foi definida no processaLogin()
                    
                    // Redireciona para dashboard
                    header('Location: /dashboard');
                    exit();
                } else {
                    // Login falhou - sua classe já salvou o erro nos logs
                    $error = "Usuário ou senha inválidos. Tente novamente.";
                }
            } else {
                $error = "Por favor, preencha todos os campos";
            }
        }

        // Renderiza a tela de login SEM sidebar
        View::renderWithoutSidebar('page/login.html.php', [
            'error' => $error ?? null
        ], 'login');
    }

    public function logout()
    {
        // Limpa todas as variáveis de sessão
        $_SESSION = array();
        
        // Se existe cookie de sessão, remove ele
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroi a sessão
        session_destroy();
        
        // Redireciona para login
        header('Location: /login');
        exit();
    }
}












































































// class LoginController extends PageControl
// {
    

       
//      private $login;



//     public function __construct()
//     {
//         $this->login = new RequestChavesEmauto();
//     }



//     public function login()

//     {
           
//         // Verifica se o usuário já está logado
//       //  if (isset($_SESSION['user'])) {
//            print_r( $_POST);

        

//             $user = $_POST['usuario'] ?? '';
//             $pass = $_POST['senha'] ?? '';
     

//             if (!empty($_POST['usuario']) && !empty($_POST['senha'])) {

//                 $this->login->processaLogin([$user,$pass]);
//                 }
           
        
//         View::render('page/login.html.php', [
          
//         ], 'login');
//     }

  


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



























