<?php
include("login/authenticate.php");

?>
<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicos Autonômos</title>
    <link rel="stylesheet" href="public/style.css" type="text/css">
   

    <!-- Bootstrap configuration--->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/script.js"></script>

</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Entrar</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="register-form-link">Registrar</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="" method="post" role="form" style="display: block;">
                                <p class="error" id="error-user-not-found"><?php echo $errorUserNotFound?></p>
                                    <div class="form-group">
                                        <input type="email" name="email" id="username" tabindex="1" class="form-control" placeholder="E-mail" value="">
                                        <p class="error"><?php echo $erroEmail?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="senha" id="password" tabindex="2" class="form-control" placeholder="Senha">
                                        <p class="error"><?php echo $erroSenha?></p>
                                    </div>
                                    <div class="form-group text-center">
                                        <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                                        <label for="remember">Lembre-se</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Entrar">
                                            </div>
                                        </div>
                                    </div>
                               
                                </form>
                                <form id="register-form" action="" method="post" role="form" style="display: none;">
                                    <div class="form-group">
                                        <input type="text" name="nome" id="username" tabindex="1" class="form-control" placeholder="Nome Completo" value="">
                                        <p class="error"><?php echo $erroName?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="cpf" id="cpf" tabindex="1" class="form-control" placeholder="CPF" value="">
                                        <p class="error"><?php echo $erroCPF?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email-registro" id="email" tabindex="1" class="form-control" placeholder="Endereço de e-mail" value="">
                                        <p class="error"><?php echo $erroEmailRegistro?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="telefone" id="phone" tabindex="2" class="form-control" placeholder="Telefone">
                                        <p class="error"><?php echo $erroTelefone?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="senha-registro" id="password" tabindex="2" class="form-control" placeholder="Senha">
                                        <p class="error"><?php echo $erroConfirmarSenha?></p>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmar-senha" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirme a senha">
                                        <p class="error"><?php echo $erroConfirmarSenha?></p>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="envio-registro" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registrar">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>