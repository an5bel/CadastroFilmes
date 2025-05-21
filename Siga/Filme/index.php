<?php
require_once("../Classes/Filme.class.php");

if (\$_SERVER['REQUEST_METHOD'] == 'POST') {
    \$id = isset(\$_POST['id']) ? intval(\$_POST['id']) : 0;
    \$titulo = \$_POST['titulo'] ?? '';
    \$diretor = \$_POST['diretor'] ?? '';
    \$ano = intval(\$_POST['ano'] ?? 0);
    \$genero = \$_POST['genero'] ?? '';
    \$avaliacao = floatval(\$_POST['avaliacao'] ?? 0);

    if (!empty(\$_FILES['poster']['name'])) {
        \$destino = PATH_UPLOAD . 'uploads/' . basename(\$_FILES['poster']['name']);
        move_uploaded_file(\$_FILES['poster']['tmp_name'], \$destino);
        \$poster = 'uploads/' . basename(\$_FILES['poster']['name']);
    } else {
        \$poster = \$_POST['poster_atual'] ?? '';
    }

    \$acao = \$_POST['acao'] ?? '';
    \$filme = new Filme(\$id, \$titulo, \$diretor, \$ano, \$genero, \$avaliacao, \$poster);

    if (\$acao == 'salvar') {
        \$resultado = (\$id > 0) ? \$filme->alterar() : \$filme->inserir();
    } elseif (\$acao == 'excluir') {
        \$resultado = \$filme->excluir();
    }

    if (\$resultado) header("Location: index.php");
    else echo "Erro ao processar: " . \$acao;

} else {
    \$form = file_get_contents('form_cad_filme.html');
    \$id = isset(\$_GET['id']) ? intval(\$_GET['id']) : 0;
    \$lista = Filme::listar(1, \$id);
    if (count(\$lista) > 0) {
        \$f = \$lista[0];
        \$form = str_replace('{id}', \$f->getId(), \$form);
        \$form = str_replace('{titulo}', \$f->getTitulo(), \$form);
        \$form = str_replace('{diretor}', \$f->getDiretor(), \$form);
        \$form = str_replace('{ano}', \$f->getAno(), \$form);
        \$form = str_replace('{genero}', \$f->getGenero(), \$form);
        \$form = str_replace('{avaliacao}', \$f->getAvaliacao(), \$form);
        if (\$f->getPoster()) {
            \$link = "<br><a href='" . \$f->getPoster() . "' download>Download atual</a>";
        } else {
            \$link = '';
        }
        \$form = str_replace('{poster_link}', \$link, \$form);
    } else {
        foreach(['id','titulo','diretor','ano','genero','avaliacao'] as \$campo)
            \$form = str_replace('{'.\$campo.'}', '', \$form);
        \$form = str_replace('{id}', 0, \$form);
        \$form = str_replace('{poster_link}', '', \$form);
    }
    echo \$form;
    include_once('lista_filme.php');
}
?>