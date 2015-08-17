<?php

isset($_SESSION) || session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$host     = $_SERVER['SERVER_ADDR'] . ':' . dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'default.fdb';
$username = 'sysdba';
$password = 'masterkey';
$conexao  = ibase_connect($host, $username, $password);
//ibase_query($conexao, "INSERT INTO usuarios (id, nome, email, senha) VALUES (1, 'Admin', 'admin@localhost.com', '".sha1(md5(123456))."')");

