<?php
	include("../classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	
	require_once("../classeForm/InterfaceExibicao.php");
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeForm.php");
	require_once("../classeForm/classeButton.php");

if(isset($_POST["id"])){
	require_once("conexao.php");
	require_once("classeControllerBD.php");
	$c = new ControllerBD($conexao);
	$colunas=array("id_compra","data_compra","nome_usuario");
	$tabelas[0][0]="compra";
	$tabelas[0][1]=null;
	$ordenacao = null;
	$condicao = $_POST["id"];
	
	$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
	$linha = $stmt->fetch(PDO::FETCH_ASSOC);
	$value_id_compra = $linha["id_compra"];
	$value_data_compra = $linha["data_compra"];
	$value_nome_usuario= $linha["nome_usuario"];
	$action = "altera.php?tabela=compra";
}
else{
	$action = "insere.php?tabela=compra";
	$value_id_compra="";
	$value_data_compra="";
	$value_nome_usuario =""
	
}

	$v = array("action"=>$action,"method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"ID_COMPRA","placeholder"=>"ID DA COMPRA...","value"=>$value_id_compra);
	$f->add_input($v);
	$v = array("type"=>"date","name"=>"DATA_COMPRA","placeholder"=>"DATA DA COMPRA...","value"=>$value_data_compra);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"NOME_USUARIO","placeholder"=>"NOME...","value"=>$value_nome_usuario);
	$f->add_input($v);
	$v = array("type"=>"button","texto"=>"ENVIAR");
	$f->add_button($v);	
?>

<h3>Formulário - Inserir Compra</h3>
<div id="status"></div>

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
				url: "insere.php?tabela=compra",
				type: "post",
				data: {
                    ID_COMPRA: $("input[name='ID_COMPRA']").val(),
                    DATA_COMPRA: $("input[name='DATA_COMPRA']").val(),
                    NOME_USUARIO: $("input[name='NOME_USUARIO']").val(),


					},
					beforeSend: function(d){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Compra inserida com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Compra não inserida: Codigo já existente.");
							$("#status").css("color","red");
						}
					}
		});
	});
 });

</script>
</body>
</html>
</html>