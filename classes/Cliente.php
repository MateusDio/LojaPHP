<?php

// Classe representa a tabela clientes
class Cliente {

    // Atributos privados (Encapsulamento)
    private $id;
    private $nome;
    private $email;

    // Construtor é executado ao criar o objeto
    public function __construct($id, $nome, $email) {

        // $this representa o próprio objeto
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
    }

    // Getter retorna o ID
    public function getId() {
        return $this->id;
    }

    // Getter retorna o nome
    public function getNome() {
        return $this->nome;
    }

    // Getter retorna o email
    public function getEmail() {
        return $this->email;
    }

    // Setter altera o nome
    public function setNome($nome) {
        $this->nome = $nome;
    }

    // Setter altera o email
    public function setEmail($email) {
        $this->email = $email;
    }
}