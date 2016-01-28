<?php

require_once "src/Sys/Conexao.php";
require_once "src/Sys/Sessao.php";
require_once "src/Sys/Usuario.php";
require_once "src/Sys/ValidacaoException.php";

use Sys\Conexao;
use Sys\Sessao;
use Sys\Usuario;
use Sys\ValidacaoException;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    try {
        $conexao = new Conexao('localhost', 'sistema_login', 'root', '');
        $sessao = new Sessao();
        $usuario = new Usuario($conexao);

        $u = $usuario->validar($email, md5($senha));
        $sessao->gravar('usuario_logado', $u);

        header('location: index.php');
        exit;
    } catch (ValidacaoException $ex) {
        $mensagem = $ex->getMessage();
    } catch (\PDOException $ex) {
        $mensagem = 'Erro na conexão com o banco de dados';
    }
}


?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap-responsive.min.css">
    <style>
        .box-login {
            padding: 10px 14px 0 14px;
            background: #f7f7f7;
            border: 1px solid #ddd;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="height: 100px;"></div>

        <?php if (isset($mensagem)): ?>
        <div class="row">
            <div class="span4 offset4">
                <div class="alert alert-danger alert-block"><?= $mensagem ?></div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="span4 offset4">
                <div class="box-login">
                    <form class="form-horizontal" action="login.php" method="post">
                        <div class="control-group">
                            <label for="control-label">Email</label>
                            <input class="input-block-level" type="text" name="email" placeholder="Endereço de e-mail">
                        </div>
                        <div class="control-group">
                            <label for="control-label">Senha</label>
                            <input class="input-block-level" type="password" name="senha" placeholder="Sua senha">
                        </div>
                        <div class="control-group">
                            <input class="btn btn-primary btn-block" type="submit" value="Entrar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
