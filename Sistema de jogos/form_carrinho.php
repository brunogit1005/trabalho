<?php
	include("classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	include("conexao.php");
	
	require_once("classeForm/InterfaceExibicao.php");
	require_once("classeForm/classeInput.php");
	require_once("classeForm/classeSelect.php");
	require_once("classeForm/classeOption.php");
	require_once("classeForm/classeButton.php");
	require_once("classeForm/classeForm.php");

	if(isset($_POST["id"])){
		require_once("classeControllerBD.php");
		$c = new ControllerBD($conexao);
		$colunas = array("id_carrinho","num_cartao","modo_pagamento","cod_jogo","cod_usuario","cod_compra");
		$tabela[0][0]="carrinho";
		$tabela[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabela,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_carrinho= $linha["id_carrinho"];
		$value_num_cartao = $linha["num_cartao"];
		$value_modo_pagamento= $linha["modo_pagamento"];
		$value_cod_jogo $linha["cod_jogo"];
        $value_cod_usuario= $linha["cod_usuario"];
        $value_cod_compra= $linha["cod_compra"];
		$action = "altera.php?tabela=carrinho";
	}
	else{
        $action = "altera.php?tabela=carrinho";
		$value_id_carrinho = "";
		$value_num_cartao = "";
		$value_modo_pagamento = "";
		$value_cod_jogo = "";
		$value_cod_usuario = "";
		$value_cod_compra = "";
		$action = "insere.php?tabela=carrinho";			
	}
	
	$select = "SELECT ID_USUARIO AS value, USUARIO AS texto FROM usuario ORDER BY ID_USUARIO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_usuario[] = $linha;
	}	

	$select = "SELECT ID_COMPRA AS value, COMPRA AS texto FROM compra ORDER BY ID_COMPRA";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_compra[] = $linha;
    }	
    
    $select = "SELECT ID_JOGO AS value, JOGO AS texto FROM jogo ORDER BY ID_JOGO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_jogo[] = $linha;
	}	

	$v = array("action"=>"insere.php?tabela=funcao","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"ID_CARRINHO","placeholder"=>"ID DO CARRINHO...","value"=>$value_id_carrinho);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"NUM_CARTAO","placeholder"=>"NUMERO DO CARTAO...","value"=>$value_num_cartao);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"MODO_PAGAMENTO","placeholder"=>"MODO DE PAGAMENTO...","value"=>$value_modo_pagamento);
	$f->add_input($v);
	$f->add_input($v);
	
	$v = array("name"=>"ID_USUARIO","label"=>"Usuario");
	$f->add_select($v,$matriz_usuario);
    
    $v = array("name"=>"ID_COMPRA","label"=>"Compra");
    $f->add_select($v,$matriz_compra);

    $v = array("name"=>"ID_JOGO","label"=>"Jogo");
    $f->add_select($v,$matriz_compra);
	$v = array("texto"=>"ENVIAR");
    $f->add_button($v);	
?>

<h3>Formulário - Inserir Carrinho</h3>

<hr />
<?php
	$f->exibe();
?>
<script>
 //quando o documento estiver pronto
 $(function(){

//definaa sa seguinte regra para o botão de envio
$("button").click(function(){
		$.ajax({
				url: "insere.php?tabela=funcionario",
				type: "post",
				data: {
                    ID_CARRINHO: $("input[name='ID_CARRINHO']").val(),
                    NUM_CARTAO: $("input[name='NUM_CARTAO']").val(),
                    MODO_PAGAMENTO: $("input[name='MODO_PAGAMENTO']").val(),
                    ID_USUARIO: $("input[name='ID_USUARIO']").val(),
                    ID_COMPRA: $("input[name='ID_COMPRA']").val(),
                    ID_JOGO: $("input[name='ID_JOGO']").val(),

					},
					beforeSend: function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Carrinho inserido com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Carrinho não inserido: Codigo já existente.");
							$("#status").css("color","yellow");
						}
					}
		});
	});
 });

</script>
</body>
</html>
</html>