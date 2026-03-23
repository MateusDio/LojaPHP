<?php

// Importa conexão
require_once "config/Database.php";

// Importa model
require_once "models/Cliente.php";

class ClienteDAO {

    // Atributo que armazenará a conexão
    private $conn;

    // Construtor cria conexão automaticamente
    public function __construct() {

        // Instancia Database
        $database = new Database();

        // Obtém conexão
        $this->conn = $database->getConnection();
    }

    // Método responsável por inserir dados
    public function inserir(Cliente $cliente) {

        // SQL com parâmetros nomeados
        $sql = "INSERT INTO clientes (nome, email)
                VALUES (:nome, :email)";

        // Prepara a query
        $stmt = $this->conn->prepare($sql);

        // Associa valores aos parâmetros
        $stmt->bindValue(":nome", $cliente->getNome());
        $stmt->bindValue(":email", $cliente->getEmail());

        // Executa e retorna verdadeiro ou falso
        return $stmt->execute();
    }
}