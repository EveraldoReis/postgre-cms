<?php
require '../includes/conexao.php';
require '../includes/rotas.php';
$base .= '/admin';
if (isset($_SESSION['auth_token']))
{
    $sql            = "SELECT id, nome, email, senha FROM usuarios WHERE token = '" . sha1($_SESSION['auth_token']) . "'";
    $query          = ibase_query($conexao, $sql);
    $usuario_logado = ibase_fetch_object($query);
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel</title>
        <base href="/vivi/admin/" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script src="ckeditor/ckeditor.js"></script>
    </head>
    <body>
        <?php if (isset($_SESSION['auth_token'])): ?>
            <?php require 'page.php'; ?>
        <?php else: ?>
            <form id="login" action="login.php" method="post">
                <h2>Login</h2>
                <div class="form-control">
                    <label>E-mail</label>
                    <input type="email" placeholder="Digite seu e-mail" name="email" />
                </div>
                <div class="form-control">
                    <label>Senha</label>
                    <input type="password" placeholder="Digite sua senha" name="password" />
                </div>
                <div class="form-control">
                    <hr/>
                    <button>Entrar</button>
                </div>
            </form>
        <?php endif; ?>
        <script type="text/javascript" src="js/scripts.js" />
    </body>
</html>
