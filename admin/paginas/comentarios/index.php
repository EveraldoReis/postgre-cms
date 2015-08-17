<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['apagar']))
{
    $id    = (int) $_GET['apagar'];
    $sql   = "DELETE FROM comentarios WHERE id = '{$id}'";
    $query = ibase_query($conexao, $sql);

    if ($query)
    {
        echo 'Item deletado com sucesso!';
    }
}

$sql = "SELECT a.*, b.id AS postagem_id, b.titulo AS postagem, c.id AS usuario_id, c.nome AS usuario FROM comentarios a LEFT JOIN postagens b ON b.id = a.postagem_id LEFT JOIN usuarios c ON c.id = a.usuario_id";

$query = ibase_query($conexao, $sql);

$i = 1;

?>
<h2>Comentarios</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Data</th>
            <th>Autor</th>
            <th>Postagem</th>
            <th colspan="2"></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($comentario = ibase_fetch_object($query, IBASE_TEXT)): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $comentario->DATA; ?></td>
                <td><a href="index.php/usuarios/formulario/<?php echo $comentario->USUARIO_ID; ?>"><?php echo $comentario->USUARIO ? $comentario->USUARIO : 'Anônimo'; ?></a></td>
                <td><a href="index.php/postagens/formulario/<?php echo $comentario->POSTAGEM_ID; ?>"><?php echo $comentario->POSTAGEM; ?></a></td>
                <td><a href="index.php/comentarios/formulario/<?php echo $comentario->ID; ?>">Editar</a></td>
                <td><a href="index.php/comentarios?apagar=<?php echo $comentario->ID; ?>">Remover</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>