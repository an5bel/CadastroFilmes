<?php
    require_once("../Classes/Filme.class.php");
    $busca = isset($_GET['busca']) ? $_GET['busca'] : 0;
    $tipo  = isset($_GET['tipo'])  ? $_GET['tipo']  : 0;
   
    $lista = Filme::listar($tipo, $busca);
    $itens = '';

    foreach ($lista as $filme) {
        $item = file_get_contents('itens_listagem_filmes.html');
        $item = str_replace('{id}',$filme->getId(),$item);
        $item = str_replace('{titulo}',$filme->getTitulo(),$item);
        $item = str_replace('{diretor}',$filme->getDiretor(),$item);
        $item = str_replace('{ano}',$filme->getAno(),$item);
        $item = str_replace('{genero}',$filme->getGenero(),$item);
        $item = str_replace('{avaliacao}',$filme->getAvaliacao(),$item);

        $poster = $filme->getPoster();
        if (!empty($poster)) {
            $link = htmlspecialchars($poster);
        } else {
            $link = '';
        }
        $item .= "\n"; 
        $item = str_replace('{poster}', $link, $item);

        $itens .= $item;
    }
    $listagem = file_get_contents('listagem_filme.html');
    $listagem = str_replace('{itens}', $itens, $listagem);
    print($listagem);
?>
