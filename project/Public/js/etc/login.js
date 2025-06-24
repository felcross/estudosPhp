document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const forgotPasswordForm = document.getElementById('forgotPasswordForm');
    const loginContainer = document.querySelector('.login-form-container');
    const forgotContainer = document.querySelector('.forgot-password-container');
    const alertaLogin = document.getElementById('alertaLogin');

    // Função para mostrar/esconder loading
    function toggleLoading(button, isLoading) {
        const btnText = button.querySelector('.btn-text');
        const btnLoading = button.querySelector('.btn-loading');

        if (isLoading) {
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
            button.disabled = true;
        } else {
            btnText.style.display = 'inline-block';
            btnLoading.style.display = 'none';
            button.disabled = false;
        }
    }

    // Função para mostrar mensagem de erro
    function showError(message) {
        alertaLogin.textContent = message;
        alertaLogin.style.display = 'block';
    }

    // Função para limpar mensagens
    function clearMessages() {
        alertaLogin.textContent = '';
        alertaLogin.style.display = 'none';
    }

    // Login Form Submit
    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        clearMessages();

        const entrarBtn = document.getElementById('entrarBtn');
        const usuario = document.getElementById('usuario').value;
        const senha = document.getElementById('senha').value;
        const csrfToken = document.getElementById('csrf_token').value;

        // Validação básica
        if (!document.getElementById('confirme').checked) {
            showError('Por favor, confirme sua conexão!');
            return;
        }

        toggleLoading(entrarBtn, true);

        try {
            

            // Adicione uma verificação de segurança

            if (!csrfToken) {
                showError('Token de segurança não encontrado. Recarregue a página.');
                return;
            }

            // Envia dados via JSON com headers corretos para AJAX
            const response = await fetch('index.php?class=LoginController&method=processLogin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Header que identifica AJAX
                },
                body: JSON.stringify({
                    usuario: usuario,
                    senha: senha,
                    csrf_token: csrfToken // TOKEN AQUI

                })
            });

            // Verifica se a resposta é JSON válida
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                throw new Error('Resposta inválida do servidor');
            }

            const result = await response.json();



            if (result.success) {
                // Sucesso - redireciona para ProductController->buscar
                console.log(result);
                window.location.href = 'index.php?class=ProductController&method=buscar';
            } else {
                // Erro - mostra mensagem
                showError(result.message || 'Usuário ou senha inválidos!');
            }
        } catch (error) {
            // TRATAMENTO ESPECÍFICO PARA CSRF
            if (error.message && error.message.includes('CSRF')) {
                showError('Token de segurança inválido. Recarregue a página.');
            } else {
                showError('Erro de conexão! Tente novamente.');
            }



            console.error('Erro no login:', error);
            showError('Erro de conexão! Tente novamente.');
        } finally {
            toggleLoading(entrarBtn, false);
        }
    });

    // Esqueci minha senha
    if (document.getElementById('forgotPasswordBtn')) {
        document.getElementById('forgotPasswordBtn').addEventListener('click', function () {
            loginContainer.style.display = 'none';
            forgotContainer.style.display = 'block';
        });

        document.getElementById('voltarLoginBtn').addEventListener('click', function () {
            forgotContainer.style.display = 'none';
            loginContainer.style.display = 'block';
        });

        // Forgot Password Form Submit
        forgotPasswordForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('emailRecuperacao').value;
            const enviarBtn = document.getElementById('enviarSenhaBtn');
            const sucessoDiv = document.getElementById('sucessoRecuperacao');
            const erroDiv = document.getElementById('erroRecuperacao');

            // Esconde mensagens anteriores
            sucessoDiv.style.display = 'none';
            erroDiv.style.display = 'none';

            enviarBtn.disabled = true;
            enviarBtn.textContent = 'Enviando...';

            try {
                const response = await fetch('index.php?class=LoginController&method=forgotPassword', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ email: email })
                });

                const result = await response.json();

                if (result.success) {
                    sucessoDiv.style.display = 'block';
                } else {
                    erroDiv.textContent = result.message || 'Erro ao enviar email!';
                    erroDiv.style.display = 'block';
                }
            } catch (error) {
                erroDiv.textContent = 'Erro de conexão!';
                erroDiv.style.display = 'block';
            } finally {
                enviarBtn.disabled = false;
                enviarBtn.textContent = 'Enviar senha';
            }
        });
    }
});