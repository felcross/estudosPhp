<style>
    @import url("../public/css/login.css");
</style>




<div class="container login">


    <div class="mx-auto login shadow p-4 mb-5 bg-white rounded" style="position:relative; z-index:5000;">

        <div class="img-center">
            <div class="login">
                <img src="./photo/logo.png" width="200px" alt="Logo da Emsoft">
            </div>
        </div>

        <div login>

            <form method="POST">
                <div class="form-group">
                    <label for="usuario">Usuário</label>
                    <input type="text" class="form-control" name='usuario' id="usuario" aria-describedby="emailHelp" placeholder="Seu usuário" autocomplete="off">
                    <small class="form-text text-muted">Nunca compartilhe seu acesso a terceiros</small>
                </div>
                <br>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" name='senha' id="senha" placeholder="Senha" autocomplete="off">
                </div>
                <br>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="confirme" value="login">
                    <label for="confirme">Confirme aqui sua conexão</label>
                    <br><small class="form-text text-muted" style="color:red !important;" id="AlertaMin"></small>

                </div>
                <br>

                <button type="submit" id="Entrar" class="btn btn-primary">Entrar</button>
            </form>
        </div>

        <div altsenha style="display:none;">
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="form-group">
                    <label for="usuario">Email</label>
                    <input type="email" class="form-control" id="emailS" aria-describedby="emailHelp" placeholder="Seu usuário" autocomplete="off">
                    <small class="form-text text-muted">Você receberá uma nova senha por email</small>
                </div>
                <br>
                <div class="alert alert-success" role="alert" sucess style="display:none;">
                    Senha enviada com sucesso!
                </div>
                <div class="alert alert-danger" role="alert" danger style="display:none;">
                    Erro! Tente novamente mais tarde!
                </div>


                <button type="button" id="Novasenha" class="btn btn-primary">Enviar senha</button>
            </form>
            <br>
            <div class="container text-center">
                <div class="row justify-content-end">
                    <div class="col-4">

                    </div>
                    <div class="col-4">
                        <div class="col-md-2">
                            <button type="button" voltaLogin class="btn btn-outline-light " emauto="cadmsg"><ion-icon name="arrow-undo-outline" class="icones-azuis" size="large"></ion-icon></button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>
<br>


<input type="hidden" name="emauto_token" value="<?php echo $_SESSION['TokenCSRF']; ?>">



<footer class="Rodape">

    <div class="grid text-end fixed-bottom">
        <div class="g-col-4 g-col-md-4"></div>
        <div class="g-col-4 g-col-md-4"></div>

    </div>

    <div class="sub-rodape">
        Sistemas de Gestão Empresarial no Setor de Varejo e Distribuição de Autopeças.
    </div>

    <p>&copy;Portal de Clientes V 2.0</p>

</footer>


