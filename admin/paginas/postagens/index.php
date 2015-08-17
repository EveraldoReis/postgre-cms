<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_GET['apagar']))
{
    $id    = (int) $_GET['apagar'];
    $sql   = "DELETE FROM postagens WHERE id = '{$id}'";
    $query = ibase_query($conexao, $sql);

    if ($query)
    {
        echo 'Item deletado com sucesso!';
    }
}

$sql = "SELECT a.*, b.id AS pagina_id, b.nome AS pagina, c.id AS autor_id, c.nome AS autor FROM postagens a INNER JOIN paginas b ON b.id = a.pagina_id INNER JOIN usuarios c ON c.id = a.autor_id";

$query = ibase_query($conexao, $sql);
$i = 1;
?>
<h2>Postagens</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Titulo</th>
            <th>Página</th>
            <th>Autor</th>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($postagem = ibase_fetch_object($query, IBASE_TEXT)): ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $postagem->TITULO; ?></td>
                <td><a href="index.php/paginas/formulario/<?php echo $postagem->PAGINA_ID; ?>"><?php echo $postagem->PAGINA; ?></a></td>
                <td><a href="index.php/usuarios/formulario/<?php echo $postagem->AUTOR_ID; ?>"><?php echo $postagem->AUTOR; ?></a></td>
                <td><a href="index.php/postagens/formulario/<?php echo $postagem->ID; ?>">Editar</a></td>
                <td><a href="index.php/postagens?apagar=<?php echo $postagem->ID; ?>">Remover</a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
        </tr>
    </tfoot>
</table>