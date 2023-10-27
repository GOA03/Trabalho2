<?php

    use Pecee\SimpleRouter\SimpleRouter as Router;

    require_once "Conexao.php";  // Certifique-se de incluir a classe de conexão

    class ReceitasController {
        private $bd;  // Armazena a conexão com o banco de dados

        // O construtor é chamado automaticamente quando um objeto desta classe é criado
        public function __construct() {
            $this->bd = Conexao::get();  // Obtém a conexão com o banco de dados usando a classe Conexao
        }

        // Método para listar todas as receitas
        public function listar() {
            $query = $this->bd->prepare("SELECT * FROM receitas");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);

            $receitas = [];
            foreach ($result as $row) {
                $receitas[] = new Receita($row->nome, $row->ingredientes, $row->modo_preparo, $row->id);
            }

            return $receitas;
        }

        // Método para adicionar uma receita ao banco de dados
        public function adicionar(Receita $receita) {
            $query = $this->bd->prepare("INSERT INTO receitas(nome, ingredientes, modo_preparo) VALUES(:nome, :ingredientes, :modo_preparo)");
            $query->bindParam(':nome', $receita->getNome());
            $query->bindParam(':ingredientes', $receita->getIngredientes());
            $query->bindParam(':modo_preparo', $receita->getModoPreparo());
            $query->execute();
        }

        // Método para buscar uma receita específica por seu ID
        public function buscarPorId($id) {
            $query = $this->bd->prepare("SELECT * FROM receitas WHERE id = :id LIMIT 1");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);

            if ($result) {
                return new Receita($result->nome, $result->ingredientes, $result->modo_preparo, $result->id);
            }

            return null;  // Retorna nulo se a receita não for encontrada
        }

        // Método para visualizar uma receita específica
        public function visualizar($id) {
            $receita = $this->buscarPorId($id);
        
            if ($receita) {
                include_once './views/visualizar.view.php';
            } else {
                echo "Receita não encontrada.";
            }
        }

        // Método para editar uma receita existente
        public function editar(Receita $receita) {
            $query = $this->bd->prepare("UPDATE receitas SET nome = :nome, ingredientes = :ingredientes, modo_preparo = :modo_preparo WHERE id = :id");
            $query->bindParam(':nome', $receita->getNome());
            $query->bindParam(':ingredientes', $receita->getIngredientes());
            $query->bindParam(':modo_preparo', $receita->getModoPreparo());
            $query->bindParam(':id', $receita->getId());
            $query->execute();
        }

        // Método para remover uma receita do banco de dados
        public function remover($id) {
            $query = $this->bd->prepare("DELETE FROM receitas WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
        }
    }
?>
