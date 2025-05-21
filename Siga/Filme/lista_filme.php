<?php
require_once("../Classes/Filme.class.php");
$busca = $_GET['busca'] ?? '';
$tipo  = intval($_GET['tipo'] ?? 0);
$lista = Filme::listar($tipo, $busca);
$itens = '';
foreach ($lista as $f) {
    $item = file_get_contents('itens_listagem_filmes.html');
    foreach (['id','titulo','diretor','ano','genero','avaliacao','poster'] as $campo) {
        $item = str_replace('{'.$campo.'}', $f->{'get'.ucfirst($campo)}(), $item);
    }
    $itens .= $item;
}
$visao = file_get_contents('listagem_filme.html');
$visao = str_replace('{itens}', $itens, $visao);
echo $visao;
?>