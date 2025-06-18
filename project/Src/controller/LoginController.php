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
use SessionManager;



class LoginController extends PageControl
{
    private $login;

    public function __construct()
    {
        $this->login = new RequestChavesEmauto();
    }

    public function login()
    {

        // if (AuthMiddleware::isAuthenticated()) {
        //     header('Location: ?class=ProductController&method=buscar');
        //     exit();
        // }

        // Renderiza a página de login usando componentes
        View::render('page/login.html.php', [
            'title' => 'Login - Sistema'
        ], 'login');
    }

    public function processLogin()
    {

        header('Content-Type: application/json');

        try {
            // Verifica se é POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Método não permitido');
            }

            // Pega dados JSON
            $input = json_decode(file_get_contents('php://input'), true);

            if (!$input) {
                throw new Exception('Dados inválidos');
            }

            $usuario = $input['usuario'] ?? '';
            $senha = $input['senha'] ?? '';

            // Validações básicas
            if (empty($usuario) || empty($senha)) {
                throw new Exception('Usuário e senha são obrigatórios');
            }

            // IMPORTANTE: Chama o processaLogin que autentica no endpoint
            $loginResult = $this->login->processaLogin([$usuario, $senha]);

            if (!$loginResult) {
                throw new Exception($loginResult['message'] ?? 'Usuário ou senha inválidos');
            }

            $userData = ['user' => $usuario];
            if ($loginResult) {
                SessionManager::setUserLogin($userData);
            }

            // Se chegou aqui, login foi bem-sucedido
            // O $loginResult deve conter o token e outros dados do endpoint

            // Configura sessão com os dados retornados
            //  SessionManager::setUserLogin($loginResult);

            // Resposta de sucesso
            echo json_encode([
                'success' => true,
                'message' => 'Login realizado com sucesso',
                //  'token' => $loginResult['token'] ?? null,
                'redirect' => '?class=ProductController&method=buscar'
            ]);





        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}

























