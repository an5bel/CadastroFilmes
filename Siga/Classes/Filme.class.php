<?php
require_once("Database.class.php");
class Filme {
    private $id;
    private $titulo;
    private $diretor;
    private $ano;
    private $genero;
    private $avaliacao;
    private $poster;

    public function __construct($id, $titulo, $diretor, $ano, $genero, $avaliacao, $poster) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->diretor = $diretor;
        $this->ano = $ano;
        $this->genero = $genero;
        $this->avaliacao = $avaliacao;
        $this->poster = $poster;
    }

    public function getId(): int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getDiretor(): string { return $this->diretor; }
    public function getAno(): int { return $this->ano; }
    public function getGenero(): string { return $this->genero; }
    public function getAvaliacao(): float { return $this->avaliacao; }
    public function getPoster(): string { return $this->poster; }

    public function setTitulo($titulo) {
        if (empty($titulo)) throw new Exception("Título é obrigatório");
        $this->titulo = $titulo;
    }
    public function setDiretor($diretor) {
        if (empty($diretor)) throw new Exception("Diretor é obrigatório");
        $this->diretor = $diretor;
    }
    public function setAno($ano) {
        if ($ano < 1800 || $ano > intval(date("Y"))) throw new Exception("Ano inválido");
        $this->ano = $ano;
    }
    public function setGenero($genero) {
        if (empty($genero)) throw new Exception("Gênero é obrigatório");
        $this->genero = $genero;
    }
    public function setAvaliacao($avaliacao) {
        if ($avaliacao < 0 || $avaliacao > 10) throw new Exception("Avaliação deve ser entre 0 e 10");
        $this->avaliacao = $avaliacao;
    }
    public function setPoster($poster = '') {
        $this->poster = $poster;
    }

    public function inserir(): bool {
        $sql = "INSERT INTO filme (titulo, diretor, ano, genero, avaliacao, poster) VALUES (:titulo, :diretor, :ano, :genero, :avaliacao, :poster)";
        $params = [
            ':titulo' => $this->getTitulo(),
            ':diretor' => $this->getDiretor(),
            ':ano' => $this->getAno(),
            ':genero' => $this->getGenero(),
            ':avaliacao' => $this->getAvaliacao(),
            ':poster' => $this->getPoster()
        ];
        return Database::executar($sql, $params) == true;
    }

    public static function listar($tipo = 0, $info = ''): array {
        $sql = "SELECT * FROM filme";
        switch ($tipo) {
            case 1:
                $sql .= " WHERE id = :info";
                $params = [':info' => $info];
                break;
            case 2:
                $sql .= " WHERE titulo LIKE :info";
                $params = [':info' => '%'.$info.'%'];
                break;
                $params = [];
            case 3:
                $sql .= " WHERE diretor LIKE :info";
                $params = [':info' => '%'.$info.'%'];
                break;
                $params = [];
            case 4:
                $sql .= " WHERE ano LIKE :info";
                $params = [':info' => '%'.$info.'%'];
                break;
                $params = [];
            case 5:
                $sql .= " WHERE genero LIKE :info";
                $params = [':info' => '%'.$info.'%'];
                break;
                $params = [];
            case 6:
                $sql .= " WHERE avaliacao LIKE :info";
                $params = [':info' => '%'.$info.'%'];
                break;
            default:
                $params = [];
        }
        $stmt = Database::executar($sql, $params);
        $lista = [];
        while ($row = $stmt->fetch()) {
            $lista[] = new Filme(
                $row['id'], $row['titulo'], $row['diretor'],
                $row['ano'], $row['genero'], $row['avaliacao'], $row['poster']
            );
        }
        return $lista;
    }

    public function alterar(): bool {
        $sql = "UPDATE filme SET titulo=:titulo, diretor=:diretor, ano=:ano, genero=:genero, avaliacao=:avaliacao, poster=:poster WHERE id=:id";
        $params = [
            ':id' => $this->getId(),
            ':titulo' => $this->getTitulo(),
            ':diretor' => $this->getDiretor(),
            ':ano' => $this->getAno(),
            ':genero' => $this->getGenero(),
            ':avaliacao' => $this->getAvaliacao(),
            ':poster' => $this->getPoster()
        ];
        return Database::executar($sql, $params) == true;
    }

    public function excluir(): bool {
        $sql = "DELETE FROM filme WHERE id = :id";
        return Database::executar($sql, [':id' => $this->getId()]) == true;
    }
}
?>