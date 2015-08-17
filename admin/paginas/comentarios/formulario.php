<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dados = array(
    'texto' => '',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'texto' =>filter_var($_POST['texto'], FILTER_UNSAFE_RAW),
    );
    $sql   = "INSERT INTO comentarios(id, texto) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM comentarios) + 1, '{$dados['texto']}') RETURNING id";
    if ($rotas['id'])
    {
        $sql = "UPDATE comentarios  SET texto = '{$dados['texto']}' WHERE id = '{$rotas['id']}' RETURNING id";
    }
    $query = ibase_query($conexao, $sql);

    $resultado = ibase_fetch_object($query);

    if ($resultado)
    {
        header("Location: $base/index.php/{$rotas['pagina']}/formulario/{$resultado->ID}");
    }
    echo 'Houve um erro ao salvar os dados. Tente novamente.<br/>' . ibase_errmsg();
}

if ($rotas['id'])
{
    $sql = "SELECT a.*, b.id AS postagem_id, b.titulo AS postagem_titulo, c.id AS usuario_id, c.nome AS usuario_nome FROM comentarios a LEFT JOIN postagens b ON b.id = a.postagem_id LEFT JOIN usuarios c ON c.id = a.usuario_id WHERE a.id = '{$rotas['id']}'";

    $query = ibase_query($conexao, $sql);

    $dados = ibase_fetch_assoc($query, IBASE_TEXT);
    
    $dados = array_change_key_case($dados, CASE_LOWER);
}
?>
<h2>Editar comentário</h2>
<form action="" method="post">
    <label>Usuário</label><br/>
    <a href="index.php/usuarios/formulario/<?php echo $dados['usuario_id']; ?>"><?php echo $dados['usuario_nome'] ? $dados['usuario_nome'] : 'Anônimo'; ?></a><br/><br/>
    <label>Postagem</label><br/>
    <a href="index.php/postagens/formulario/<?php echo $dados['postagem_id']; ?>"><?php echo $dados['postagem_titulo']; ?></a><br/><br/>
    <label>Texto</label><br/>
    <textarea name="texto"><?php echo $dados['texto']; ?></textarea><br/><br/>
    <button>Salvar</button>
</form>