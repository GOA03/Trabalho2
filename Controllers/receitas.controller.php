<?php

    // Carrega o autoload
    require_once __DIR__ . '/../vendor/autoload.php';

    use Pecee\SimpleRouter\SimpleRouter as Router;

    class ReceitasController {
        private $bd;  // Armazena a conexão com o banco de dados

        // Inicializa o objeto
        public function __construct() {
            // Estabelece a conexão com o banco
            $this->bd = Conexao::get();
        }

        // Lista as receitas
        public function listar() {
            // Prepara a consulta SQL
            $query = $this->bd->prepare("SELECT * FROM receitas");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_OBJ);

            // Processa o resultado
            $receitas = [];
            foreach ($result as $row) {
                $receitas[] = new Receita($row->nome, $row->ingredientes, $row->modo_preparo, $row->id);
            }

            // Retorna a lista de receitas
            return $receitas;
        }

        // Adiciona uma receita
        public function adicionar(Receita $receita = null) {
            // Verifica se uma receita foi passada
            if ($receita === null) {
                // Verifica se os dados foram enviados
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'])) {
                    // Limpa os dados
                    $nome = strip_tags(trim($_POST['nome']));
                    $ingredientes = strip_tags(trim($_POST['ingredientes']));
                    $modo_preparo = strip_tags(trim($_POST['modo_preparo']));

                    // Cria a receita
                    $receita = new Receita($nome, $ingredientes, $modo_preparo);
                } else {
                    // Exibe mensagem de erro
                    echo "Erro: Nenhuma receita fornecida.";
                    return;
                }
            }

            // Insere a receita no banco
            $query = $this->bd->prepare("INSERT INTO receitas(nome, ingredientes, modo_preparo) VALUES(:nome, :ingredientes, :modo_preparo)");
            $nomeReceita = $receita->getNome();
            $ingredientesReceita = $receita->getIngredientes();
            $modoPreparoReceita = $receita->getModoPreparo();
            $query->bindParam(':nome', $nomeReceita);
            $query->bindParam(':ingredientes', $ingredientesReceita);
            $query->bindParam(':modo_preparo', $modoPreparoReceita);

            // Verifica o resultado
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

        // Verifica se a receita existe
        private function receitaExiste(Receita $receita) {
            // Prepara a consulta SQL
            $query = $this->bd->prepare("SELECT COUNT(*) FROM receitas WHERE nome = :nome AND ingredientes = :ingredientes AND modo_preparo = :modo_preparo");
            $query->bindParam(':nome', $receita->getNome());
            $query->bindParam(':ingredientes', $receita->getIngredientes());
            $query->bindParam(':modo_preparo', $receita->getModoPreparo());
            $query->execute();

            // Retorna o resultado
            return $query->fetchColumn() > 0;
        }

        // Busca a receita por ID
        public function buscarPorId($id) {
            // Prepara a consulta SQL
            $query = $this->bd->prepare("SELECT * FROM receitas WHERE id = :id LIMIT 1");
            $query->bindParam(':id', $id);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);

            // Verifica o resultado
            if ($result) {
                return new Receita($result->nome, $result->ingredientes, $result->modo_preparo, $result->id);
            }

            // Retorna nulo se não encontrar
            return null;
        }

        // Visualiza a receita
        public function visualizar($id) {
            $receita = $this->buscarPorId($id);
            
            if ($receita) {
                include_once './views/visualizar.view.php'; 
            } else {
                echo "Receita não encontrada.";
            }
        }        

        // Edita a receita
        public function editar($id) {
            $receita = $this->buscarPorId($id);

            if (!$receita) {
                echo "Receita não encontrada!";
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['ingredientes'], $_POST['modo_preparo'])) {
                $nome = strip_tags(trim($_POST['nome']));
                $ingredientes = strip_tags(trim($_POST['ingredientes']));
                $modo_preparo = strip_tags(trim($_POST['modo_preparo']));
                $receita->setNome($nome);
                $receita->setIngredientes($ingredientes);
                $receita->setModoPreparo($modo_preparo);
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
