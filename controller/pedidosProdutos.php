<?php
    require_once '../DAO/Conexao.php';
    require_once '../DAO/PedidosProdutosDAO/pedidosProdutosGET.php';
    require_once '../DAO/PedidosProdutosDAO/pedidosProdutosPOST.php';
    require_once '../DAO/PedidosProdutosDAO/pedidosProdutosPUT.php';
    require_once '../DAO/PedidosProdutosDAO/pedidosProdutosPATCH.php';
    require '../DAO/PedidosProdutosDAO/pedidosProdutosDELETE.php';
    require '../Model/PedidosProdutosModel/PedidosProdutos.php';
    require '../Model/PedidosProdutosModel/RespostaPedidosProdutos.php';
    require './pedidosProdutosUtils.php';
    $req = $_SERVER;
    $conexao = conectar();
    
    //echo $req["REQUEST_METHOD"];
     switch ($req["REQUEST_METHOD"]) {
         case 'GET':
            $pedidosProdutos = json_encode(pegar_pedidosProdutos($conexao));
            echo $pedidosProdutos;
             break;
         case 'POST':
             
             $u = receberDados();
             
             $resp = incluir_pedidosProdutos($conexao, $u);
             
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
            $id_produto = $dados->id_produto;

            $u = receberDados();

            $resp = editar_pedidosProdutos($conexao, $u, $id_produto);

            $in = new Resposta('', '');
                if($resp){
                   $in = criarResposta('204', 'Atualizado com sucesso');
                } else {
                  $in = criarResposta('400', 'Não atualizado');
                }

            echo json_encode($in);
             break;
         case 'PATCH':

            $resp = editar_pedidoProdutos_parcialmente($conexao);
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
                if (isset($dados->id_pedido)) {
                    $id_pedido = $dados->id_pedido;
            
                    // Chama a função para deletar o cliente
                    $resp = deletar_pedidoProdutos($conexao, $id_pedido);
                    $resposta = new Resposta('', '');
            
                    if ($resp) {
                        $resposta = criarResposta('204', 'Excluido com sucesso');
                    } else {
                        $resposta = criarResposta('400', 'Não foi possível excluir');
                    }
                } else {
                    // Resposta de erro se o ID não foi fornecido
                    $resposta = criarResposta('400', 'ID do pedido nao fornecido');
                }
            
                echo json_encode($resposta);
                break;
            ;          
         default:
             # code...
             break;
     }





?>