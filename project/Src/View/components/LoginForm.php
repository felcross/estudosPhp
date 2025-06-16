<?php
// src/view/components/LoginForm.php
/**
 * Props esperadas:
 * - $Class: string - classe para redirecionamento após login
 * - $Method: string - método para redirecionamento após login
 * - $logoPath: string - caminho da logo
 * - $showForgotPassword: bool - mostrar opção de recuperar senha
 */
?>

<div class="container login">
    <div class="mx-auto login shadow p-4 mb-5 bg-white rounded" style="position:relative; z-index:5000;">
        
        <!-- Logo -->
        <div class="img-center">
            <div class="login">
                <img src="<?= htmlspecialchars($logoPath ?? './photo/logo.png') ?>" width="200px" alt="Logo">
            </div>
        </div>

        <!-- Formulário de Login -->
        <div class="login-form-container">
            <form id="loginForm" method="POST" action="index.php?class=LoginController&method=processLogin">
                <!-- Dados para redirecionamento -->
                <input type="hidden" name="class" value="<?= htmlspecialchars($class ?? '') ?>">
                <input type="hidden" name="method" value="<?= htmlspecialchars($method ?? '') ?>">
                
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" class="form-control" name="usuario" id="usuario" 
                           placeholder="Seu usuário" autocomplete="off" required>
                    <small class="form-text text-muted">Nunca compartilhe seu acesso a terceiros</small>
                </div>
                <br>
                
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name="senha" id="senha" 
                           placeholder="Senha" autocomplete="off" required>
                </div>
                <br>
                
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="confirme" required>
                    <label for="confirme">Confirme aqui sua conexão</label>
                    <br><small class="form-text text-danger" id="alertaLogin"></small>
                </div>
                <br>
                
                <button type="submit" id="entrarBtn" class="btn btn-primary">
                    <span class="btn-text">Entrar</span>
                    <span class="btn-loading" style="display: none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Entrando...
                    </span>
                </button>
                
                <?php if ($showForgotPassword ?? true): ?>
                <div class="mt-3">
                    <button type="button" class="btn btn-link" id="forgotPasswordBtn">
                        Esqueci minha senha
                    </button>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Formulário de Recuperação de Senha -->
        <?php if ($showForgotPassword ?? true): ?>
        <div class="forgot-password-container" style="display:none;">
            <form id="forgotPasswordForm">
                <div class="form-group">
                    <label for="emailRecuperacao">Email</label>
                    <input type="email" class="form-control" id="emailRecuperacao" 
                           placeholder="Seu email" autocomplete="off" required>
                    <small class="form-text text-muted">Você receberá uma nova senha por email</small>
                </div>
                <br>
                
                <div class="alert alert-success" id="sucessoRecuperacao" style="display:none;">
                    Senha enviada com sucesso!
                </div>
                <div class="alert alert-danger" id="erroRecuperacao" style="display:none;">
                    Erro! Tente novamente mais tarde!
                </div>

                <button type="submit" id="enviarSenhaBtn" class="btn btn-primary">Enviar senha</button>
                <button type="button" id="voltarLoginBtn" class="btn btn-outline-secondary ms-2">
                    Voltar ao Login
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearMessages();
        
        const entrarBtn = document.getElementById('entrarBtn');
        const formData = new FormData(this);
        
        // Validação básica
        if (!document.getElementById('confirme').checked) {
            showError('Por favor, confirme sua conexão!');
            return;
        }
        
        toggleLoading(entrarBtn, true);
        
        try {
            const response = await fetch('index.php?class=LoginController&method=processLogin', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                // Sucesso - redireciona
                const class = formData.get('class') || 'ProductController';
                const method = formData.get('method') || 'buscar';
                
                window.location.href = `index.php?class=${class}&method=${method}`;
            } else {
                // Erro - mostra mensagem
                showError(result.message || 'Usuário ou senha inválidos!');
            }
        } catch (error) {
            console.error('Erro no login:', error);
            showError('Erro de conexão! Tente novamente.');
        } finally {
            toggleLoading(entrarBtn, false);
        }
    });
    
    // Esqueci minha senha
    if (document.getElementById('forgotPasswordBtn')) {
        document.getElementById('forgotPasswordBtn').addEventListener('click', function() {
            loginContainer.style.display = 'none';
            forgotContainer.style.display = 'block';
        });
        
        document.getElementById('voltarLoginBtn').addEventListener('click', function() {
            forgotContainer.style.display = 'none';
            loginContainer.style.display = 'block';
        });
        
        // Forgot Password Form Submit
        forgotPasswordForm.addEventListener('submit', async function(e) {
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
</script>
