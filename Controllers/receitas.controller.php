<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use Pecee\SimpleRouter\SimpleRouter as Router;

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
        public function adicionar(Receita $receita = null) {
            // Verifique se um objeto Receita foi passado
            if ($receita === null) {
                // Se não, verifica se os dados do formulário foram enviados
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'])) {
                    $nome = strip_tags(trim($_POST['nome']));
                    $ingredientes = strip_tags(trim($_POST['ingredientes']));
                    $modo_preparo = strip_tags(trim($_POST['modo_preparo']));

                    // Cria um novo objeto Receita com os dados do formulário
                    $receita = new Receita($nome, $ingredientes, $modo_preparo);
                } else {
                    // Se não houver dados do formulário, trata como uma chamada do roteador sem argumentos
                    echo "Erro: Nenhuma receita fornecida.";
                    return;
                }
            }

            // Prepara a query SQL
            $query = $this->bd->prepare("INSERT INTO receitas(nome, ingredientes, modo_preparo) VALUES(:nome, :ingredientes, :modo_preparo)");

            // Variáveis intermediárias
            $nomeReceita = $receita->getNome();
            $ingredientesReceita = $receita->getIngredientes();
            $modoPreparoReceita = $receita->getModoPreparo();

            // Vincula os parâmetros da query aos valores da receita
            $query->bindParam(':nome', $nomeReceita);
            $query->bindParam(':ingredientes', $ingredientesReceita);
            $query->bindParam(':modo_preparo', $modoPreparoReceita);

            // Executa a query
            if ($query->execute()) {
                echo '<script>
                            alert("Receita adicionada com sucesso!");
                            setTimeout(function() {
                                window.location.href = "/Trabalho2/receitas";
                            });
                      </script>';
            } else {
                echo '<script>alert("Erro ao adicionar a receita. Por favor, tente novamente.");</script>';
            }
        }

        // Função para verificar se uma receita já existe no banco de dados (opcional)
        private function receitaExiste(Receita $receita) {
            $query = $this->bd->prepare("SELECT COUNT(*) FROM receitas WHERE nome = :nome AND ingredientes = :ingredientes AND modo_preparo = :modo_preparo");
            $query->bindParam(':nome', $receita->getNome());
            $query->bindParam(':ingredientes', $receita->getIngredientes());
            $query->bindParam(':modo_preparo', $receita->getModoPreparo());
            $query->execute();

            return $query->fetchColumn() > 0;
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

        // Método para editar uma receita existente usando ID
        public function editar($id) {
            // Busque a receita pelo ID
            $receita = $this->buscarPorId($id);

            // Verifique se a receita foi encontrada
            if (!$receita) {
                echo "Receita não encontrada!";
                return;
            }

            // Se os dados do formulário forem enviados, atualize a receita no banco de dados.
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'])) {
                // Obtenha os novos dados do formulário
                $nome = strip_tags(trim($_POST['nome']));
                $ingredientes = strip_tags(trim($_POST['ingredientes']));
                $modo_preparo = strip_tags(trim($_POST['modo_preparo']));

                // Atualize o objeto $receita
                $receita->setNome($nome);
                $receita->setIngredientes($ingredientes);
                $receita->setModoPreparo($modo_preparo);

                // Salve as alterações no banco de dados
                $query = $this->bd->prepare("UPDATE receitas SET nome = :nome, ingredientes = :ingredientes, modo_preparo = :modo_preparo WHERE id = :id");
                $query->bindParam(':nome', $nome);
                $query->bindParam(':ingredientes', $ingredientes);
                $query->bindParam(':modo_preparo', $modo_preparo);
                $query->bindParam(':id', $id);
                if ($query->execute()) {
                    echo "Receita atualizada com sucesso!";
                    header('Location: /Trabalho2/receitas');
                    exit;
                } else {
                    echo "Erro ao atualizar a receita.";
                }
            }

            // Renderize a view (template) para editar a receita
            include_once './views/editar.view.php';
        }


        // Método para remover uma receita do banco de dados
        public function remover($id) {
            $query = $this->bd->prepare("DELETE FROM receitas WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
        }
    }
?>
