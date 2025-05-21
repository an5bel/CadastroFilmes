<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "Classes" . DIRECTORY_SEPARATOR . "Filme.class.php");

$busca = $_GET['busca'] ?? '';
$tipo  = intval($_GET['tipo'] ?? 0);
$lista = Filme::listar($tipo, $busca);
$itens = '';

foreach ($lista as $f) {
    // Usa caminho absoluto com DIRECTORY_SEPARATOR para maior compatibilidade
    $itemPath = __DIR__ . DIRECTORY_SEPARATOR . 'itens_listagem_filmes.html';
    if (!file_exists($itemPath)) {
        die('Template de item não encontrado em ' . $itemPath);
    }
    $item = file_get_contents($itemPath);
    foreach (['id','titulo','diretor','ano','genero','avaliacao','poster'] as $campo) {
        $getter = 'get' . ucfirst($campo);
        $item = str_replace('{' . $campo . '}', $f->$getter(), $item);
    }
    $itens .= $item;
}

// Carrega o template de listagem completo usando DIRECTORY_SEPARATOR
$listPath = __DIR__ . DIRECTORY_SEPARATOR . 'listagem_filme.html';
if (!file_exists($listPath)) {
    die('Template de listagem não encontrado em ' . $listPath);
}
$visao = file_get_contents($listPath);
$visao = str_replace('{itens}', $itens, $visao);
echo $visao;
?>