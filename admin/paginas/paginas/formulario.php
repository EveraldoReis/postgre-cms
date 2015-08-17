<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dados = array(
    'nome' => '',
    'menu' => '',
    'slug' => '',
    'ordenacao' => '0',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'nome' => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
        'menu' => filter_var($_POST['menu'], FILTER_SANITIZE_STRING),
        'slug' => preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(strtr(filter_var($_POST['menu'], FILTER_SANITIZE_STRING), ' ', '-'))),
        'ordenacao' => filter_var($_POST['ordenacao'], FILTER_VALIDATE_INT),
    );
    $sql   = "INSERT INTO paginas(id, nome, menu, slug, ordenacao) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM paginas) + 1, '{$dados['nome']}', '{$dados['menu']}', '{$dados['slug']}', '{$dados['ordenacao']}') RETURNING id";
    if ($rotas['id'])
    {
        $sql = "UPDATE paginas  SET nome = '{$dados['nome']}', menu = '{$dados['menu']}', slug = '{$dados['slug']}', ordenacao = '{$dados['ordenacao']}' WHERE id = '{$rotas['id']}' RETURNING id";
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
    $sql = "SELECT * FROM paginas WHERE id = '{$rotas['id']}'";

    $query = ibase_query($conexao, $sql);

    $dados = ibase_fetch_assoc($query);
    
    $dados = array_change_key_case($dados, CASE_LOWER);
}
?>
<h2><?php echo $rotas['id'] ? 'Editar' : 'Criar nova'; ?> página</h2>
<form action="" method="post">
    <label>Nome da Página</label><br/>
    <input required name="nome" value="<?php echo $dados['nome']; ?>" placeholder="Nome da página" type="text" /><br/><br/>
    <label>Nome do Menu</label><br/>
    <input required name="menu" value="<?php echo $dados['menu']; ?>" placeholder="Nome do menu" type="text" /><br/><br/>
    <label>Posição do Menu</label><br/>
    <input required name="ordenacao" value="<?php echo $dados['ordenacao']; ?>" placeholder="Posição do menu" type="text" /><br/><br/>
    <button>Salvar</button>
</form>