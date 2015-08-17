<?php

$base = '/vivi';

$uri = str_replace($base, '', $_SERVER['REQUEST_URI']);
$uri = end(explode('index.php', $uri));
$uri = array_shift(explode('?', $uri));
$uri = trim(trim($uri, '.php'), '/');
preg_match('/([^\/]+)?\/?([^\/]+)?\/?([^\/]+)?/', $uri, $rotas);

$rotas = array_merge($rotas,
        array(
    'pagina' => 'inicial',
    'acao'   => 'index',
    'id'     => '',
    '',
    '',
    ''));

$rotas['pagina'] = ($rotas[1] == '/' || $rotas[1] == '') ? 'inicial' : $rotas[1];
$rotas['acao']   = $rotas[2] == '' ? 'index' : $rotas[2];
$rotas['id']     = (int) $rotas[3];

//print_r($rotas);