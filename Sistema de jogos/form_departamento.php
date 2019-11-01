<?php

	include("../classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	include("conexao.php");
	
	require_once("../classeForm/InterfaceExibicao.php");
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeSelect.php");
	require_once("../classeForm/classeOption.php");
	require_once("../classeForm/classeButton.php");
	require_once("../classeForm/classeForm.php");

	if(isset($_POST["id"])){
		require_once("classeControllerBD.php");
		$c = new ControllerBD($conexao);
		$colunas = array("*");
		$tabelas[0][0]="departamento";
		$tabelas[0][1]="gerente";
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_departamento = $linha["ID_DEPARTAMENTO"];
		$value_nome_departamento = $linha["NOME_DEPARTAMENTO"];
		
		$selected_id_gerente = $linha["ID_GERENTE"];
		$selected_id_localizacao = $linha["ID_LOCALIZACAO"];
		
		
		$action = "alterar.php?tabela=departamento";

		$disabled = true;
		
	}
	else{
		$disabled = false;
		$value_id_departamento = null;
		$value_nome_departamento = null;
		$selected_id_localizacao = null;
		$selected_id_gerente = null;
		

		$action = "insere.php?tabela=departamento";			
	}
	

	$select = "SELECT ID_GERENTE AS value, CONCAT(SOBRENOME,', ',NOME) AS texto FROM gerente ORDER BY NOME";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_gerente[] = $linha;
	}	

	$select = "SELECT ID_LOCALIZACAO AS value, ENDERECO AS texto FROM localizacao ORDER BY ENDERECO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_localizacao[] = $linha;
	}
	


	$v = array("action"=>"insere.php?tabela=departamento","method"=>"post");
	$f = new Form($v);

	$v = array("type"=>"number","name"=>"ID_DEPARTAMENTO","placeholder"=>"ID DO DEPARTAMENTO...","value"=>$value_id_departamento, "disabled"=>$disabled);
	$f->add_input($v);

	if($disabled == true){
		array("type"=>"hidden","name"=>"ID_DEPARTAMENTO");

	}
	$v = array("type"=>"text","name"=>"NOME_DEPARTAMENTO","placeholder"=>"NOME DO DEPARTAMENTO...","value"=>$value_nome_departamento);
	$f->add_input($v);

	$v = array("name"=>"ID_GERENTE","selected"=>$selected_id_gerente);
	$f->add_select($v,$matriz_gerente);

	$v = array("name"=>"ID_LOCALIZACAO","selected"=>$selected_id_localizacao);
	$f->add_select($v,$matriz_localizacao);

	$v = array("type"=>"button","texto"=>"ENVIAR");
	$f->add_button($v);	
?>

<h3>Formulário - Inserir Departamento</h3>
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
				url: "insere.php?tabela=departamento",
				type: "post",
				data: {
						ID_DEPARTAMENTO: $("input[name='ID_DEPARTAMENTO']").val(),
						NOME_DEPARTAMENTO: $("input[name='NOME_DEPARTAMENTO']").val(),
						ID_GERENTE: $("input[name='ID_GERENTE']").val(),
						ID_LOCALIZACAO: $("input[name='ID_LOCALIZACAO']").val()
					},
					beforeSend: function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Região inserida com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Região não inserida: Codigo já existente.");
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