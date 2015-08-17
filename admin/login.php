<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../includes/conexao.php';

if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'senha' => sha1(md5($_POST['password'])),
        'email' => filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
    );
    $sql   = "SELECT id FROM usuarios WHERE senha = '{$dados['senha']}' AND email = '{$dados['email']}'";

    $query = ibase_query($conexao, $sql);

    $resultado = ibase_fetch_object($query);

    if ($resultado)
    {
        $_SESSION['auth_token'] = md5($resultado->ID);

        $sql = "UPDATE usuarios SET token = '" . sha1($_SESSION['auth_token']) . "' WHERE senha = '{$dados['senha']}' AND email = '{$dados['email']}'";

        $query = ibase_query($conexao, $sql);
        header('Location: ' . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../'));
    }
    echo 'Dados inválidos';
}