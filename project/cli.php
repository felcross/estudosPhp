<?php

require 'autoload.php';
session_start();
include_once "./config/base.php";

/**
 * Verifica se o arquivo de configuração "chave_privada.pem" existe.
 * Se não existir, gera uma nova chave criptográfica e a salva no arquivo.
 * Caso contrário, exibe uma mensagem informando que o arquivo já existe.
 */
if (!isset($argv[1])) {
    echo PHP_EOL . "Bem-vindo ao Painel de Configuração!" . PHP_EOL .
        "Escolha uma das opções abaixo:" . PHP_EOL .
        "1) init - Necessário para que o HUB funcione perfeitamente." . PHP_EOL .
        "2) defUser - Utilizado para configurar os usuários de acesso a API." . PHP_EOL .
        "3) ping - Utilizado para testar se a integração entre as API's estão funcionando. " . PHP_EOL .
        "4) deleteLogs - Utilizado para excluir todos os registros de logs. " . PHP_EOL .
        "5) cadChaves - Utilizado para cadastrar a as chaves da FastChannel. " . PHP_EOL .
        "6) defTabelaPreco- Utilizado para cadastrar a tabela de preços padrão da FastChannel. " . PHP_EOL .
        "7) defDistrib- Utilizado para cadastrar a tabela de preços padrão da FastChannel. " . PHP_EOL .
        
        PHP_EOL;
}

/**
 * Gera uma chave criptográfica aleatória e a salva em um arquivo.
 * 
 * Este método utiliza a função `openssl_random_pseudo_bytes` para gerar uma chave de 32 bytes 
 * (256 bits) e a armazena no arquivo "chave_privada.pem" localizado na pasta "./config".
 * Após salvar a chave, exibe uma mensagem informando o sucesso da operação e instruções sobre 
 * a configuração do usuário e o uso correto do comando.
 * 
 * @return void
 */
function gerarChaves(): void
{
    $chave = openssl_random_pseudo_bytes(32); // Gera uma chave aleatória de 32 bytes (256 bits)
    file_put_contents("./config/chave_privada.pem", $chave);
    print (PHP_EOL . "Dados gerados com sucesso! Agora configure o usuário." . PHP_EOL . "LEMBRE-SE, não utilize mais de uma vez esse comando init, caso se faça necessário, " . PHP_EOL . "phppara cada utilização deste comando será necessário utilizar defUsuario" . PHP_EOL . PHP_EOL);
}

/**
 * Criptografa o conteúdo fornecido utilizando AES-256-CBC com uma chave privada.
 * 
 * O método verifica se o arquivo "chave_privada.pem" existe, carrega a chave privada
 * a partir desse arquivo e gera um vetor de inicialização (IV) aleatório. Em seguida, 
 * utiliza o algoritmo de criptografia `AES-256-CBC` para criptografar o conteúdo fornecido.
 * O resultado é então codificado em Base64 e retornado. Caso o arquivo da chave privada 
 * não exista, uma mensagem de erro é retornada.
 *
 * @param mixed $conteudo O conteúdo a ser criptografado. Pode ser uma string ou qualquer valor.
 * @return string Retorna o conteúdo criptografado codificado em Base64 ou uma mensagem de erro.
 */
function criptografar(mixed $conteudo)
{

    if (file_exists("./config/chave_privada.pem")) {
        $key = file_get_contents("./config/chave_privada.pem");

        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $textoCriptografado = openssl_encrypt($conteudo, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode(base64_encode($iv . $textoCriptografado));
    } else {
        return PHP_EOL . "Não Criptografado - Ocorreu um erro" . PHP_EOL . PHP_EOL;
    }
}

/**
 * Define e armazena um usuário e senha criptografados em um arquivo de configuração.
 * 
 * O método espera um parâmetro `$dados` que deve conter o nome de usuário e a senha,
 * separados por vírgula. Ambos os valores são criptografados utilizando a função 
 * `criptografar()` e salvos no arquivo `user.ini` na pasta de configuração. Se o número 
 * de parâmetros fornecidos for menor que dois, uma mensagem de erro é exibida. Caso
 * contrário, os dados criptografados são armazenados com sucesso ou uma mensagem de erro
 * é exibida caso algo falhe no processo.
 *
 * @param string $dados Uma string contendo o usuário e senha, separados por vírgula.
 * @return void
 */
function defUsuarios($dados)
{
    $dividir = explode(",", $dados);

    if (count($dividir) < 2) {
        print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar o usuário. Você deve enviar usuário e senha juntos, separados por ','" . PHP_EOL .
            "Exemplo: php cli.php defUser joao,123" . PHP_EOL . PHP_EOL);
    } else {

        try {
            $user = criptografar($dividir[0]);
            $pass = criptografar($dividir[1]);

            $conteudo = "[USER]\n";
            $conteudo .= "usuario = \"$user\" \n";
            $conteudo .= "senha = \"$pass\" \n";
            $conteudo .= "\n";


            file_put_contents("./config/user.ini", $conteudo);
            print (PHP_EOL . "Usuário cadastrado com sucesso!" . PHP_EOL .
                "Caso necessite reiniciar a integração através do comando init, será necessário cadastrar o usuário novamente." . PHP_EOL . PHP_EOL);
        } catch (\Throwable $th) {
            print ($th);
            print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar os usuários, reinicie a aplicação com o comando init" . PHP_EOL . PHP_EOL);
        }
    }
}

/**
 * Define a tabela de preços criptografando os dados fornecidos
 * e salvando-os em um arquivo de configuração.
 *
 * O conteúdo é salvo no arquivo './config/tabCodigo.ini' no formato INI.
 * Em caso de erro, uma mensagem de erro será exibida no console.
 *
 * @param mixed $dados Dados a serem criptografados para representar a tabela de preços.
 *
 * @return void
 */
function defTabelaPreco($dados)
{

    try {
        $tab = criptografar($dados);

        $conteudo = "[TABELA]\n";
        $conteudo .= "codigo = \"$tab\" \n";
        $conteudo .= "\n";

        file_put_contents("./config/tabCodigo.ini", $conteudo);
        print (PHP_EOL . "Tabela cadastrada com sucesso!" . PHP_EOL .
            "Caso necessite reiniciar a integração através do comando init, será necessário cadastrar o usuário novamente." . PHP_EOL . PHP_EOL);
    } catch (\Throwable $th) {
        print ($th);
        print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar a tabela de preço. Tente novamente mais tarde!" . PHP_EOL . PHP_EOL);
    }

}

/**
 * Define a unidade de distribuição (estoque) criptografando os dados fornecidos
 * e salvando-os em um arquivo de configuração.
 *
 * O conteúdo é salvo no arquivo './config/undCodigo.ini' no formato INI.
 * Em caso de erro, uma mensagem de erro será exibida no console.
 *
 * @param mixed $dados Dados a serem criptografados para representar a unidade.
 *
 * @return void
 */
function defUndDistribuicao($dados)
{
    try {

        $tab = criptografar($dados);

        $conteudo = "[UND]\n";
        $conteudo .= "codigo = \"$tab\" \n";
        $conteudo .= "\n";

        file_put_contents("./config/undCodigo.ini", $conteudo);
        print (PHP_EOL . "Unidade de estoque cadastrada com sucesso!" . PHP_EOL .
            "Caso necessite reiniciar a integração através do comando init, será necessário cadastrar o usuário novamente." . PHP_EOL . PHP_EOL);
    } catch (\Throwable $th) {
        print ($th);
        print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar a unidade de estoque. Tente novamente mais tarde!" . PHP_EOL . PHP_EOL);
    }

}

/**
 * Verifica se há uma conexão ativa com a API EMAUTO.
 * 
 * A função verifica se a chave de sessão `chave` está definida. Se estiver, indica que há uma 
 * conexão ativa com a API EMAUTO e exibe uma mensagem confirmando que as configurações estão corretas.
 * Se não houver uma chave de sessão ativa, a função informa que não existem conexões ativas 
 * e sugere que o usuário verifique as configurações do script.
 *
 * @return void
 */
function ping()
{

    if (isset($_SESSION['chave'])) {
        print (PHP_EOL . "EMAUTO API - Existe uma conexão ativa no momento, o que indica que está tudo certo nas configurações." . PHP_EOL . PHP_EOL);
    } else {
        print (PHP_EOL . "EMAUTO API - Não existem conexões ativas no momento." . PHP_EOL . "Lembre-se, para verificar se as configurações estão corretas, tenha um script em execução." . PHP_EOL . PHP_EOL);
    }
}

/**
 * Exclui todos os arquivos de log (.json) localizados na pasta `./logs/`.
 *
 * A função verifica se o parâmetro `$dados` foi passado corretamente. Se o valor de `$dados` for `'s'`, 
 * todos os arquivos de log com a extensão `.txt` serão excluídos. Caso contrário, será exibida uma mensagem 
 * pedindo a confirmação para excluir os logs.
 *
 * @param string $dados Valor que confirma a exclusão dos logs. Deve ser `'s'` para proceder com a exclusão.
 * 
 * @return void
 */
function deleteLogs($dados)
{

    if ($dados !== 'U' && $dados == 's') {

        array_map('unlink', glob("./logs/*.json"));
        print (PHP_EOL . "Todos os registros de logs foram excluídos com sucesso!" . PHP_EOL .
            "Atenção! Novos registros podem ser gerados." . PHP_EOL . PHP_EOL);
    } else {
        print (PHP_EOL . "Você precisa informar se deseja realmente excluir." . PHP_EOL .
            "Exemplo: php cli.php deleteLogs s" . PHP_EOL . PHP_EOL);
    }
}

/**
 * Cadastra as chaves da FastChannel criptografando os dados fornecidos
 * e salvando-os em um arquivo de configuração.
 *
 * O conteúdo é salvo no arquivo './config/chavesOutro.ini' no formato INI.
 * Em caso de erro, uma mensagem de erro será exibida no console.
 *
 * @param mixed $dados Dados a serem criptografados para representar as chaves.
 *
 * @return void
 */
function cadChavesOutro($dados)
{
    $dividir = explode(",", $dados);

    if (count($dividir) < 5) {
        print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar as chaves. Você deve enviar separados por ','" . PHP_EOL .
            "Exemplo: php cli.php cadChaves grant_type,client_secret,client_id,scope,Subscription-Key" . PHP_EOL . PHP_EOL);
    } else {

        try {
            $grant = criptografar($dividir[0]);
            $secret = criptografar($dividir[1]);
            $id = criptografar($dividir[2]);
            $scope = criptografar($dividir[3]);
            $key = criptografar($dividir[4]);

            $conteudo = "[CHAVES]\n";
            $conteudo .= "grant = \"$grant\" \n";
            $conteudo .= "scret = \"$secret\" \n";
            $conteudo .= "id = \"$id\" \n";
            $conteudo .= "scope = \"$scope\" \n";
            $conteudo .= "key = \"$key\" \n";
            $conteudo .= "\n";


            file_put_contents("./config/chavesOutro.ini", $conteudo);
            print (PHP_EOL . "Usuário cadastrado com sucesso!" . PHP_EOL .
                "Caso necessite reiniciar a integração através do comando init, será necessário cadastrar as chaves novamente." . PHP_EOL . PHP_EOL);
        } catch (\Throwable $th) {
            print ($th);
            print (PHP_EOL . "Ocorreu um erro ao tentar cadastrar as chaves, reinicie a aplicação com o comando init" . PHP_EOL . PHP_EOL);
        }
    }
}

// Verifica se o usuário passou o nome de uma função como argumento
if (isset($argv[1])) {
    $funcao = $argv[1];  // Captura o nome da função a ser chamada

    // Verifica qual função foi chamada e executa a correspondente
    switch ($funcao) {
        case 'init':
            gerarChaves();
            break;
        case 'defUser':
            $dados = isset($argv[2]) ? $argv[2] : 'U';  // Segundo argumento para o nome
            defUsuarios($dados);
            break;
        case 'ping':
            ping();
            break;
        case 'deleteLogs':
            $dados = isset($argv[2]) ? $argv[2] : 'U';  // Segundo argumento para o nome
            deleteLogs($dados);
            break;
        case 'cadChaves':
            $dados = isset($argv[2]) ? $argv[2] : 'U';  // Segundo argumento para o nome
            cadChavesOutro($dados);
            break;
        case 'defTabelaPreco':
            $dados = isset($argv[2]) ? $argv[2] : 'U';  // Segundo argumento para o nome
            defTabelaPreco($dados);
            break;
        case 'defDistrib':
            $dados = isset($argv[2]) ? $argv[2] : 'U';  // Segundo argumento para o nome
            defUndDistribuicao($dados);
            break;

        default:
            echo PHP_EOL . "Comando incorreto! Use: init, defUser, ping, deleteLogs, cadChaves, defTabelaPreco, defDistrib\n" . PHP_EOL;
    }
}
