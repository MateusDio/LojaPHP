<?php

class Database {

    // Dados de conexão
    private $host = "localhost";
    private $db   = "loja";
    private $user = "root";
    private $pass = ""; // No XAMPP padrão, root não tem senha

    private $conn;

    // Método responsável por criar a conexão
    public function getConnection(){

        try {

            // Cria objeto PDO
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db}",
                $this->user,
                $this->pass
            );

            // Define modo de erro como exceção
            $this->conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            return $this->conn;

        } catch(PDOException $e){

            // Captura erro de conexão
            echo "Erro na conexão: " . $e->getMessage();
        }
    }
}