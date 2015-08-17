<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['apagar']))
{
    $id    = (int) $_GET['apagar'];
    $sql   = "DELETE FROM newsletters WHERE id = '{$id}'";
    $query = ibase_query($conexao, $sql);

    if ($query)
    {
        echo 'Item deletado com sucesso!';
    }
}

$sql = "SELECT a.* FROM newsletters a";

$query = ibase_query($conexao, $sql);

$i = 1;

?>
<h2>Newsletters</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>E-mail</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($newsletter = ibase_fetch_object($query)): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $newsletter->EMAIL; ?></td>
                <td><a href="index.php/newsletters?apagar=<?php echo $newsletter->ID; ?>">Remover</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>