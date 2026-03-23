<?php

// Importações
require_once "dao/ClienteDAO.php";
require_once "models/Cliente.php";

// Cria objeto DAO
$clienteDAO = new ClienteDAO();

// Verifica envio do formulário
if(isset($_POST['salvar'])) {

    // Captura dados enviados
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Cria objeto Cliente
    $cliente = new Cliente(null, $nome, $email);

    // Insere no banco
    if($clienteDAO->inserir($cliente)) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar!";
    }
}
?>

<h2>Cadastro de Clientes</h2>

<form method="POST">

    Nome: <br>
    <input type="text" name="nome" required><br><br>

    Email: <br>
    <input type="email" name="email" required><br><br>

    <button type="submit" name="salvar">Salvar</button>

</form>