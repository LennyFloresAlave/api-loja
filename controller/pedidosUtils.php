<?php 
         function criarResposta($status, $msg){
            $resp = new Resposta($status, $msg);
     
            return $resp;
         }
    
         function receberDados(){
            $dados = json_decode(file_get_contents('php://input'));
            
            $id_cliente = $dados->id_cliente;
            $data = $dados->data;
    
            $dadosPedidos = new Pedidos("", $id_cliente, $data);
            return $dadosPedidos;
        }
?>