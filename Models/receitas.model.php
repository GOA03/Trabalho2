<?php 

    class Receita {
        private $id;
        private $nome;
        private $ingredientes;
        private $modo_preparo;

        // Construtor da classe
        public function __construct($nome, $ingredientes, $modo_preparo, $id = null) {
            $this->nome = $nome;
            $this->ingredientes = $ingredientes;
            $this->modo_preparo = $modo_preparo;
            $this->id = $id;
        }

        // Método Getter para ID
        public function getId() {
            return $this->id;
        }

        // Método Getter para Nome
        public function getNome() {
            return $this->nome;
        }

        // Método Setter para Nome
        public function setNome($nome) {
            $this->nome = $nome;
        }

        // Método Getter para Ingredientes
        public function getIngredientes() {
            return $this->ingredientes;
        }

        // Método Setter para Ingredientes
        public function setIngredientes($ingredientes) {
            $this->ingredientes = $ingredientes;
        }

        // Método Getter para Modo de Preparo
        public function getModoPreparo() {
            return $this->modo_preparo;
        }

        // Método Setter para Modo de Preparo
        public function setModoPreparo($modo_preparo) {
            $this->modo_preparo = $modo_preparo;
        }
    }

?>
