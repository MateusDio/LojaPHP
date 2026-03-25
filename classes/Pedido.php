<?php
include_once("Cliente.php");
include_once("Produto.php");
class Pedido{


private $numero;
private $cliente;
private $produtos = [];

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

public function adcionarProduto($produto){
    $this->produtos[] = $produto;
}

public function calcularTotal(){
    $total = 0;
    foreach($this->produtos as $produto){
        $total += $produto->getPreco();
    }
    return $total;
}

public function exibirResumo(){
    echo 'Pedido Nº: ' . $this->numero . '<br>';
    echo 'Clientte: ' . $this->cliente->getNome() . '<br>';
    echo 'Produtos: <br>';

    foreach ($this->produtos as $produto){
        echo '- ' . $produto->getNome() . ' | R$ ' . number_format($produto->getPreco(), 2, ',' , '.') . '<br>';


        }
        echo '<strong> Total: R$ ' .  number_format($this->calcularTotal(), 2, ',', '.') . '</strong>';
}
}
?>