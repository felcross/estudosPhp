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
            <form id="loginForm">
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

