<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['apagar']))
{
    $id    = (int) $_GET['apagar'];
    $sql   = "DELETE FROM paginas WHERE id = '{$id}'";
    $query = ibase_query($conexao, $sql);

    if ($query)
    {
        echo 'Item deletado com sucesso!';
    }
}

$sql = "SELECT * FROM paginas";

$query = ibase_query($conexao, $sql);
$i = 1;
?>
<h2>Páginas</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Menu</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($pagina = ibase_fetch_object($query)): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $pagina->NOME; ?></td>
                <td><?php echo $pagina->MENU; ?></td>
                <td><a href="index.php/paginas/formulario/<?php echo $pagina->ID; ?>">Editar</a></td>
                <td><a href="index.php/paginas?apagar=<?php echo $pagina->ID; ?>">Remover</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>