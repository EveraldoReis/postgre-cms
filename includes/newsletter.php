<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './conexao.php';

$dados = array(
    'nome'  => 'Sem nome',
    'email' => '',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'nome'  => isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : $dados['nome'],
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
    );
    $sql   = "INSERT INTO newsletters(id, nome, email) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM newsletters) + 1, '{$dados['nome']}', '{$dados['email']}') RETURNING id";
    $query = ibase_query($conexao, $sql);

    $resultado = ibase_fetch_object($query);

    if ($resultado)
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
    echo 'Houve um erro ao salvar os dados. Tente novamente.<br/>' . ibase_errmsg();
}
?>