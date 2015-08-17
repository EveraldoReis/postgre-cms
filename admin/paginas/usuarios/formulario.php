<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dados = array(
    'nome' => '',
    'email' => '',
    'senha' => '',
);
if ('post' == strtolower($_SERVER['REQUEST_METHOD']))
{
    $dados = array(
        'nome' => filter_var($_POST['nome'], FILTER_SANITIZE_STRING),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'senha' => empty($_POST['senha']) ? $usuario_logado->SENHA : sha1(md5($_POST['senha'])),
    );
    $sql   = "INSERT INTO usuarios(id, nome, email, senha) VALUES ((SELECT iif(MAX(id) > 0, MAX(id), 0) FROM usuarios) + 1, '{$dados['nome']}', '{$dados['email']}', '{$dados['senha']}') RETURNING id";
    if ($rotas['id'])
    {
        $sql = "UPDATE usuarios  SET nome = '{$dados['nome']}', email = '{$dados['email']}', senha = '{$dados['senha']}' WHERE id = '{$usuario_logado->ID}' RETURNING id";
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
    $sql = "SELECT * FROM usuarios WHERE id = '{$rotas['id']}'";

    $query = ibase_query($conexao, $sql);

    $dados = ibase_fetch_assoc($query);
    
    $dados = array_change_key_case($dados, CASE_LOWER);
}
?>
<h2><?php echo $rotas['id'] ? 'Editar' : 'Criar novo'; ?> usuario</h2>
<form action="" method="post">
    <label>Nome</label><br/>
    <input required name="nome" value="<?php echo $dados['nome']; ?>" placeholder="Nome" type="text" /><br/><br/>
    <label>E-mail</label><br/>
    <input required name="email" value="<?php echo $dados['email']; ?>" placeholder="E-mail (usado para login)" type="text" /><br/><br/>
    <label>Senha</label><br/>
    <input name="senha" value="" autocomplete="off" placeholder="Senha" type="password" /><br/><br/>
    <button>Salvar</button>
</form>