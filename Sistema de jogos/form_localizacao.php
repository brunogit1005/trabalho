<?php

	include("../classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	
	require_once("../classeForm/InterfaceExibicao.php");
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeOption.php");
	require_once("../classeForm/classeSelect.php");
	require_once("../classeForm/classeForm.php");
	require_once("../classeForm/classeButton.php");


	include("conexao.php");
	
	if(isset($_POST["id"])){
		require_once("classeControllerBD.php");
		$c = new ControllerBD($conexao);
		$colunas = array("*");
		$tabelas[0][0]="localizacao";
		$tabelas[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_localizacao = $linha["ID_LOCALIZACAO"];
		$value_endereco = $linha["ENDERECO"];
		$value_cep = $linha["CEP"];
		$value_cidade = $linha["CIDADE"];
		$value_estado = $linha["ESTADO"];
		$selected_id_pais = $linha["ID_PAIS"];
		
		
		$action = "alterar.php?tabela=localizacao";

		$disabled = true;
		
	}
	else{
		$disabled = false;
		$value_endereco = null;
		$value_cep = null;
		$value_cidade = null;
		$value_estado = null;
		$selected_id_pais = null;
		$value_id_localizacao = null;

		$action = "insere.php?tabela=localizacao";			
	}

	$select = "SELECT ID_PAIS AS value, NOME_PAIS AS texto FROM pais ORDER BY NOME_PAIS";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz[] = $linha;
	}	
	

	$v = array("action"=>"insere.php?tabela=localizacao","method"=>"post");
	$f = new Form($v);

	$v = array("type"=>"text","name"=>"ID_LOCALIZACAO","placeholder"=>"ID DA LOCALIZACAO...", "value"=>$value_id_localizacao);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"ENDERECO","placeholder"=>"ENDEREÇO...", "value"=>$value_endereco);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"CEP","placeholder"=>"CEP...", "value"=>$value_cep);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"CIDADE","placeholder"=>"CIDADE...", "value"=>$value_cidade);
	$f->add_input($v);	
	$v = array("type"=>"text","name"=>"ESTADO","placeholder"=>"ESTADO...", "value"=>$value_estado);
	$f->add_input($v);
	
	$v = array("name"=>"ID_PAIS","selected"=>$selected_id_pais);
	$f->add_select($v,$matriz);

	$v = array("type"=>"button","texto"=>"ENVIAR");
	$f->add_button($v);		
?>

<h3>Formulário - Inserir Localização</h3>
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
				url: "insere.php?tabela=localizacao",
				type: "post",
				data: {
						ID_LOCALIZACAO: $("input[name='ID_LOCALIZACAO']").val(),
						ENDERECO: $("input[name='ENDERECO']").val(),
						CEP: $("input[name='CEP']").val(),
						CIDADE: $("input[name='CIDADE']").val(),
						ESTADO: $("input[name='ESTADO']").val(),
						ID_PAIS: $("select[name='ID_PAIS']").val()
					},

					beforeSend: function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Localização inserida com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Localização não inserida: Codigo já existente.");
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