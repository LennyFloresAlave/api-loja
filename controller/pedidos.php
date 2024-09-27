<?php
    require_once '../DAO/Conexao.php';
    require_once '../DAO/PedidosDAO/pedidosGet.php';
    require_once '../DAO/PedidosDAO/pedidosPost.php';
    require_once '../DAO/PedidosDAO/pedidosPut.php';
    require_once '../DAO/PedidosDAO/pedidosPatch.php';
    require '../DAO/PedidosDAO/pedidosDelete.php';
    require '../Model/PedidosModel/Pedidos.php';
    require '../Model/PedidosModel/RespostaPedidos.php';
    require './pedidosUtils.php';
    $req = $_SERVER;
    $conexao = conectar();
    
    //echo $req["REQUEST_METHOD"];
     switch ($req["REQUEST_METHOD"]) {
         case 'GET':
            $pedidos = json_encode(pegar_pedidos($conexao));
            echo $pedidos;
             break;
         case 'POST':
             
             $u = receberDados();
             
             $resp = incluir_pedidos($conexao, $u);
             
             $in = new Resposta('', '');
                if($resp){
                   $in = criarResposta('200', 'Incluso com sucesso');
                } else {
                  $in = criarResposta('400', 'não incluso');
                }
             
             echo json_encode($in);
          
             break;
         case 'PUT':
            $dados = json_decode(file_get_contents('php://input'));
            $id_cliente = $dados->id_cliente;

            $u = receberDados();

            $resp = editar_pedidos($conexao, $u, $id_cliente);

            $in = new Resposta('', '');
                if($resp){
                   $in = criarResposta('204', 'Atualizado com sucesso');
                } else {
                  $in = criarResposta('400', 'Não atualizado');
                }

            echo json_encode($in);
             break;
         case 'PATCH':

            $resp = editar_pedido_parcialmente($conexao);
            $resposta = new Resposta('','');
            if($resp){
                $resposta = criarResposta('204', 'Atualizado com sucesso');
            } else{
               $resposta = criarResposta('400', 'Não atualizado');
            }
            echo 'Atualizado com Sucesso';
             break;
       
             case 'DELETE':
                $dados = json_decode(file_get_contents('php://input'));
                
                // Verifica se o ID foi passado
                if (isset($dados->id_cliente)) {
                    $id_cliente = $dados->id_cliente;
            
                    // Chama a função para deletar o cliente
                    $resp = deletar_pedido($conexao, $id_cliente);
                    $resposta = new Resposta('', '');
            
                    if ($resp) {
                        $resposta = criarResposta('204', 'Excluido com sucesso');
                    } else {
                        $resposta = criarResposta('400', 'Não foi possível excluir');
                    }
                } else {
                    // Resposta de erro se o ID não foi fornecido
                    $resposta = criarResposta('400', 'ID do cliente nao fornecido');
                }
            
                echo json_encode($resposta);
                break;
            ;          
         default:
             # code...
             break;
     }





?>