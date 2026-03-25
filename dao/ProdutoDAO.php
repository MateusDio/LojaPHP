<?php
require_once 'config/DataBase.php';
require_once 'classes/Produto.php';

class ProdutoDAO {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function inserir(Produto $produto){
        $sql = 'INSERT INTO produto (nome, preco) VALUES (:nome, :preco)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':preco', $produto->getPreco());
        return $stmt->execute();
    }

    public function listarTodos(){
        $sql = 'SELECT * FROM produto';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produtos = [];
        foreach($result as $row){
            $produtos[] = new Produto($row['id'], $row['nome'], $row['preco']);
        }
        return $produtos;
    }

    public function buscarPorId($id){
        $sql = 'SELECT * FROM produto WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new Produto($row['id'], $row['nome'], $row['preco']);
        }
        return null;
    }
}
?>