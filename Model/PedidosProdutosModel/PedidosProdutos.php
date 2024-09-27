<?php 

    class pedidos_produtos{
        public $id_pedido;
        public $id_produto;
        public $qtd;

        function __construct($id_pedido_informado, $id_produto_informado, $qtd_informado){
            $this->id_pedido = $id_pedido_informado;
            $this->id_produto = $id_produto_informado;
            $this->qtd = $qtd_informado;
        }

        
    }
?>
