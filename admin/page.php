<?php
$pagina = 'paginas' . DIRECTORY_SEPARATOR . $rotas['pagina'] . DIRECTORY_SEPARATOR . $rotas['acao'];

if (file_exists($pagina . DIRECTORY_SEPARATOR . 'index.php'))
{
    $pagina .= DIRECTORY_SEPARATOR . 'index.php';
}
if (!file_exists($pagina . '.php'))
{
    header('Location: ' . $base . '/index.php');
}
?>
<div class="cabecalho">
    <h1 class="brand">Painel</h1>
    <div class="dados-usuario">
        <div><?php echo $usuario_logado->NOME; ?></div>
        <div><?php echo $usuario_logado->EMAIL; ?></div>
        <div><a href="logout.php">Sair</a></div>
    </div>
</div>
<ul class="menu">
    <li>
        <a href="index.php/inicial">Início</a>
    </li>
    <li class="haschild">
        <a href="index.php/paginas">Páginas</a>
        <ul>
            <li>
                <a href="index.php/paginas/formulario">Nova página</a>
            </li>
        </ul>
    </li>
    <li class="haschild">
        <a href="index.php/postagens">Postagens</a>
        <ul>
            <li>
                <a href="index.php/postagens/formulario">Nova postagem</a>
            </li>
        </ul>
    </li>
    <li class="haschild">
        <a href="index.php/usuarios">Usuários</a>
        <ul>
            <li>
                <a href="index.php/usuarios/formulario">Novo usuário</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="index.php/newsletters">Newsletters</a>
    </li>
    <li>
        <a href="index.php/comentarios">Comentários</a>
    </li>
</ul>
<div class="conteudo">
    <?php require $pagina . '.php'; ?>
</div>
<div class="rodape">
</div>