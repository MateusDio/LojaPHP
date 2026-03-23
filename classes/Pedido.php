<?php
include_once("Cliente.php");
include_once("Produto.php");
class Pedido{


private $numero;
private $cliente = new Cliente();
private $produtos = new Produto();

public function __construct($numero,$cliente, $produtos){
    $this->numero = $numero;
    $this->cliente = $cliente;
    $this->produtos = $produtos;
}

public function getNumero(){
    return $this->numero;
}


public function getCliente(){
    return $this->cliente;
}


public function getProdutos(){
    return $this->produtos;
}


public function setNumero($numero){
    $this->numero = $numero;
}

public function setCliente($cliente){
    $this->cliente = $cliente;
}

public function setProdutos($produtos){
    $this->produtos = $produtos;
}



}
?>