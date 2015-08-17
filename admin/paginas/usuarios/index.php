<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['apagar']))
{
    $id    = (int) $_GET['apagar'];
    $sql   = "DELETE FROM usuarios WHERE id = '{$id}'";
    $query = ibase_query($conexao, $sql);

    if ($query)
    {
        echo 'Item deletado com sucesso!';
    }
}

$sql = "SELECT a.* FROM usuarios a";

$query = ibase_query($conexao, $sql);

$i = 1;

?>
<h2>Usuarios</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($usuario = ibase_fetch_object($query)): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $usuario->NOME; ?></td>
                <td><?php echo $usuario->EMAIL; ?></td>
                <td><a href="index.php/usuarios/formulario/<?php echo $usuario->ID; ?>">Editar</a></td>
                <td><a href="index.php/usuarios?apagar=<?php echo $usuario->ID; ?>">Remover</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>