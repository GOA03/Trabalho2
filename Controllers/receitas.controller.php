<?php

require_once("../conexao.php");
require_once("../Models/receitas.model.php");

class ReceitasController {
    private $bd;

    public function __construct() {
        $this->bd = conexao::get();
    }

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

    public function adicionar(Receita $receita) {
        $query = $this->bd->prepare("INSERT INTO receitas(nome, ingredientes, modo_preparo) VALUES(:nome, :ingredientes, :modo_preparo)");
        $query->bindParam(':nome', $receita->getNome());
        $query->bindParam(':ingredientes', $receita->getIngredientes());
        $query->bindParam(':modo_preparo', $receita->getModoPreparo());
        $query->execute();
    }

    public function buscarPorId($id) {
        $query = $this->bd->prepare("SELECT * FROM receitas WHERE id = :id LIMIT 1");
        $query->bindParam(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if($result) {
            return new Receita($result->nome, $result->ingredientes, $result->modo_preparo, $result->id);
        }

        return null;
    }

    public function editar(Receita $receita) {
        $query = $this->bd->prepare("UPDATE receitas SET nome = :nome, ingredientes = :ingredientes, modo_preparo = :modo_preparo WHERE id = :id");
        $query->bindParam(':nome', $receita->getNome());
        $query->bindParam(':ingredientes', $receita->getIngredientes());
        $query->bindParam(':modo_preparo', $receita->getModoPreparo());
        $query->bindParam(':id', $receita->getId());
        $query->execute();
    }

    public function remover($id) {
        $query = $this->bd->prepare("DELETE FROM receitas WHERE id = :id");
        $query->bindParam(':id', $id);
        $query->execute();
    }
}
