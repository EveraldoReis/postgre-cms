<?php
require 'includes/conexao.php';
require 'includes/rotas.php';

$sql = "SELECT menu, nome, slug FROM paginas ORDER BY ordenacao";

$menus = ibase_query($conexao, $sql);

$sql = "SELECT a.*, (SELECT COUNT(*) FROM comentarios WHERE postagem_id = a.id) AS comentarios FROM postagens a INNER JOIN paginas b ON b.id = a.pagina_id INNER JOIN usuarios c ON c.id = a.autor_id WHERE ";


if (isset($_GET['pesquisa']))
{
    $sql .= " (a.titulo LIKE '%{$_GET['pesquisa']}%' OR a.texto LIKE '%{$_GET['pesquisa']}%' OR c.nome LIKE '%{$_GET['pesquisa']}%')";
}
else
{
    $sql .= " b.slug = '" . $rotas['pagina'] . "'";
    if ($rotas['id'])
    {
        $sql .= " AND a.id = '{$rotas['id']}'";
    }
}
$postagens = ibase_query($conexao, $sql);

$sql = "SELECT LIST(tags, ',') AS tags FROM postagens";

$tags = ibase_query($conexao, $sql);

$tags = ibase_fetch_object($tags, IBASE_TEXT);

$tags = explode(',', $tags->TAGS);

$tags = array_unique($tags);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <base href="/vivi/" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body class="amarelo">
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="conteiner">
            <div class="logo"><img src="media/images/logo.png" /></div>
            <div class="titulo"><h3>Dieta paleo/Emagreça comendo comida de verdade.</h3></div>
            <div class="menu fonte-vrd">
                <ul class="g-vrd brd-vrd">
                    <?php while ($menu = ibase_fetch_object($menus)): ?>
                        <li><a href="<?php echo $base . '/index.php/' . $menu->SLUG; ?>"><b><?php echo $menu->MENU; ?></b></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="destaque">
                <div class="items g-vrd brd-vrd">
                    <?php if ($rotas['id']): ?>
                        <?php $postagem = ibase_fetch_object($postagens, IBASE_TEXT); ?>
                        <div class="item">
                            <h3><?php echo $postagem->TITULO; ?></h3>
                            <div>
                                <?php echo $postagem->TEXTO; ?>
                            </div>
                            <div id="comentarios">
                                <?php require 'includes/formulario_comentario.php'; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php
                        while ($postagem = ibase_fetch_object($postagens, IBASE_TEXT)): $title = strtolower(strtr(filter_var($postagem->TITULO,
                                                    FILTER_SANITIZE_STRING), ' ', '-'));
                            ?>
                            <div class="item">
                                <h3><a href="index.php/<?php echo $rotas['pagina']; ?>/<?php
                                    echo preg_replace('/[^A-Za-z0-9-]+/', '-', $title)
                                    ?>/<?php echo $postagem->ID; ?>"><?php echo $postagem->TITULO; ?></a></h3>
                                <div>
                                    <?php echo $postagem->TEXTO; ?>
                                </div>
                                <div class="contador_comentarios">
                                    <a href="index.php/<?php echo $rotas['pagina']; ?>/<?php
                                    echo preg_replace('/[^A-Za-z0-9-]+/', '-', $title)
                                    ?>/<?php echo $postagem->ID; ?>#comentarios">Comentários <?php echo $postagem->COMENTARIOS; ?></a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="barra-lateral">
                <div class="pesquisa brd-vrd g-vrd-clr-2">
                    <form action="index.php">
                        <input placeholder="Pesquisa" name="pesquisa" type="text" />
                        <button><img src="media/images/search.png" /></button>
                    </form>
                </div>
                <div class="newsletter g-vrd-clr brd-vrd">
                    <h5><img width="32" src="media/images/envelope.png" /> Cadastre  seu email para receber nossas atualizacoes.</h5>
                    <form method="post" action="includes/newsletter.php">
                        <input name="email" type="text" />
                        <button style="display:none"></button>
                    </form>
                </div>
                <div class="social g-cnz brd-cnz">
                    <h5>Siga e compartilhe pelo Facebook</h5>
                    <div class="fb-like" data-href="http://www.dietapaleo.com.br " data-width="205" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                </div>
                <div class="metatags g-vrd-clr-2 brd-vrd">
                    <h5>TAGS</h5>
                    <?php foreach ($tags as $tag): ?>
                        <span><?php echo $tag; ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </body>
</html>
