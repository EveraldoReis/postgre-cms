<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dados = array(
    'titulo'    => '',
    'pagina_id' => '',
    'autor_id'  => '',
    'texto'     => '',
    'tags'      => '',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'titulo'    => filter_var($_POST['titulo'], FILTER_SANITIZE_STRING),
        'pagina_id' => filter_var($_POST['pagina_id'], FILTER_VALIDATE_INT),
        'autor_id'  => filter_var($_POST['autor_id'], FILTER_SANITIZE_STRING),
        'texto'     => filter_var($_POST['texto'], FILTER_UNSAFE_RAW),
        'tags'      => filter_var($_POST['tags'], FILTER_SANITIZE_STRING),
    );
    $sql   = "INSERT INTO postagens(id, titulo, autor_id, texto, tags, pagina_id) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM postagens) + 1, '{$dados['titulo']}', '{$dados['autor_id']}', '{$dados['texto']}', '{$dados['tags']}', '{$dados['pagina_id']}') RETURNING id";
    if ($rotas['id'])
    {
        $sql = "UPDATE postagens  SET titulo = '{$dados['titulo']}', autor_id = '{$dados['autor_id']}', texto = '{$dados['texto']}', tags = '{$dados['tags']}', pagina_id = '{$dados['pagina_id']}' WHERE id = '{$rotas['id']}' RETURNING id";
    }
    $query = ibase_query($conexao, $sql);

    $resultado = ibase_fetch_object($query);

    if ($resultado)
    {
        header("Location: $base/index.php/{$rotas['pagina']}/{$rotas['acao']}/{$resultado->ID}");
    }
    echo 'Houve um erro ao salvar os dados. Tente novamente.<br/>' . ibase_errmsg();
}

if ($rotas['id'])
{
    $sql = "SELECT a.*, b.id AS pagina_id, b.nome AS pagina, c.id AS autor_id, c.nome AS autor FROM postagens a INNER JOIN paginas b ON b.id = a.pagina_id INNER JOIN usuarios c ON c.id = a.autor_id WHERE a.id = '{$rotas['id']}'";

    $query = ibase_query($conexao, $sql);

    $dados = ibase_fetch_assoc($query, IBASE_TEXT);

    $dados = array_change_key_case($dados, CASE_LOWER);
}

$sql = "SELECT id,nome FROM usuarios";

$usuarios = ibase_query($conexao, $sql);

$sql = "SELECT id,nome FROM paginas";

$paginas = ibase_query($conexao, $sql);
?>
<h2><?php echo $rotas['id'] ? 'Editar' : 'Criar nova'; ?> postagem</h2>
<form action="" method="post">
    <label>Titulo</label><br/>
    <input required name="titulo" value="<?php echo $dados['titulo']; ?>" placeholder="Titulo da postagem" type="text" /><br/><br/>
    <label>Autor</label><br/>
    <select required name="autor_id">
        <?php while ($usuario = ibase_fetch_object($usuarios)): ?>
            <option <?php echo $dados['autor_id'] == $usuario->ID ? 'selected' : null; ?> value="<?php echo $usuario->ID; ?>"><?php echo $usuario->NOME; ?></option>
        <?php endwhile; ?>
    </select><br/><br/>
    <label>Página</label><br/>
    <select required name="pagina_id">
        <?php while ($pagina = ibase_fetch_object($paginas)): ?>
            <option <?php echo $dados['pagina_id'] == $pagina->ID ? 'selected' : null; ?> value="<?php echo $pagina->ID; ?>"><?php echo $pagina->NOME; ?></option>
        <?php endwhile; ?>
    </select><br/><br/>
    <label>Texto</label><br/>
    <textarea rows="20" cols="80" required id="editor1" name="texto" placeholder="Texto"><?php echo $dados['texto']; ?></textarea><br/><br/>
    <label>Tags</label><br/>
    <input name="tags" placeholder="Tags" value="<?php echo $dados['tags']; ?>" /><br/><br/>
    <button>Salvar</button>
    <script>
        CKEDITOR.editorConfig = function (config) {
            config.extraPlugins = 'filebrowser';
        };
        var roxyFileman = '<?php echo $base; ?>/fileman/index.html';
        CKEDITOR.replace('editor1', {
            filebrowserBrowseUrl: roxyFileman,
            filebrowserImageBrowseUrl: roxyFileman + '?type=image',
            removeDialogTabs: 'link:upload;image:upload'
        });
    </script>
</form>