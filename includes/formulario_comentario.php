<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dados = array(
    'usuario_id'  => '',
    'postagem_id' => '',
    'texto'       => '',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'usuario_id'  => filter_var($_POST['usuario_id'], FILTER_VALIDATE_INT),
        'postagem_id' => filter_var($_POST['postagem_id'], FILTER_VALIDATE_INT),
        'texto'       => filter_var($_POST['texto'], FILTER_UNSAFE_RAW),
    );
    $sql   = "INSERT INTO comentarios(id, usuario_id, postagem_id, texto) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM comentarios) + 1, '{$dados['usuario_id']}', '{$dados['postagem_id']}', '{$dados['texto']}') RETURNING id";
    $query = ibase_query($conexao, $sql);

    $resultado = ibase_fetch_object($query);

    if ($resultado)
    {
        header("Location: $base/index.php/{$rotas['pagina']}/{$rotas['acao']}/{$rotas['id']}");
    }
    echo 'Houve um erro ao salvar os dados. Tente novamente.<br/>' . ibase_errmsg();
}

if ($rotas['id'])
{
    $sql = "SELECT a.*, b.id AS postagem_id, b.titulo AS postagem_titulo, c.id AS usuario_id, c.nome AS usuario_nome FROM comentarios a LEFT JOIN postagens b ON b.id = a.postagem_id LEFT JOIN usuarios c ON c.id = a.usuario_id WHERE a.postagem_id = '{$rotas['id']}'";

    $query = ibase_query($conexao, $sql);
}
?>
<h2>Comentar</h2>
<form action="" method="post">
    <input type="hidden" name="usuario_id" value="0" />
    <input type="hidden" name="postagem_id" value="<?php echo $postagem->ID; ?>" />
    <label>Texto</label><br/>
    <textarea rows="10" cols="75" name="texto"><?php echo $dados['texto']; ?></textarea><br/><br/>
    <button>Comentar</button>
</form>
<hr/>
<div class="comentarios">
<?php while ($comentario = ibase_fetch_object($query, IBASE_TEXT)): ?>
    <b><?php echo $comentario->USUARIO_NOME ? $comentario->USUARIO_NOME : 'Anônimo'; ?> disse:</b><br/>
    <small><i><?php echo $comentario->DATA; ?></i></small>
    <p><?php echo $comentario->TEXTO; ?></p>
<?php endwhile; ?>
</div>