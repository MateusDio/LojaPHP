<?php
require_once 'config/DataBase.php';
require_once 'classes/Pedido.php';
require_once 'classes/Cliente.php';
require_once 'classes/Produto.php';

class PedidoDAO {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function inserir(Pedido $pedido) {
        try {
            $this->conn->beginTransaction();

            $sqlPedido = "INSERT INTO pedido (numero, cliente_id) VALUES (:numero, :cliente_id)";
            $stmtPedido = $this->conn->prepare($sqlPedido);
            $stmtPedido->bindValue(':numero', $pedido->getNumero());
            $stmtPedido->bindValue(':cliente_id', $pedido->getCliente()->getId());
            $stmtPedido->execute();

            $pedidoId = $this->conn->lastInsertId();

            $sqlItem = "INSERT INTO pedido_produto (pedido_id, produto_id, preco) VALUES (:pedido_id, :produto_id, :preco)";
            $stmtItem = $this->conn->prepare($sqlItem);

            foreach ($pedido->getProdutos() as $produto) {
                $stmtItem->bindValue(':pedido_id', $pedidoId);
                $stmtItem->bindValue(':produto_id', $produto->getId());
                $stmtItem->bindValue(':preco', $produto->getPreco());
                $stmtItem->execute();
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack();
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function listarTodos() {
        $pedidos = [];

        $sql = "SELECT p.id as pedido_id, p.numero, c.id as cliente_id, c.nome as cliente_nome, c.email as cliente_email
                FROM pedido p
                JOIN cliente c ON p.cliente_id = c.id
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $resultadoPedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultadoPedidos as $row) {
            $cliente = new Cliente($row['cliente_id'], $row['cliente_nome'], $row['cliente_email']);

            $sqlProdutos = "SELECT pr.id, pr.nome, pp.preco
                            FROM pedido_produto pp
                            JOIN produto pr ON pp.produto_id = pr.id
                            WHERE pp.pedido_id = :pedido_id";
            $stmtProdutos = $this->conn->prepare($sqlProdutos);
            $stmtProdutos->bindValue(':pedido_id', $row['pedido_id']);
            $stmtProdutos->execute();
            $produtosArray = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

            $produtos = [];
            foreach ($produtosArray as $prod) {
                $produtos[] = new Produto($prod['id'], $prod['nome'], $prod['preco']);
            }

            $pedidos[] = new Pedido($row['numero'], $cliente, $produtos);
        }

        return $pedidos;
    }
}
?>