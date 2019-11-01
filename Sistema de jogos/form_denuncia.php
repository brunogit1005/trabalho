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
		$tabelas[0][0]="denuncia";
        $tabelas[0][1]="usuario";
        $tabelas[0][2]="administrador";
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
        $value_id_denuncia = $linha["ID_DENUNCIA"];
        $value_situacao = $linha["SITUACAO"];
		
		$selected_id_usuario = $linha["ID_USUARIO"];
		$selected_id_adm = $linha["ID_ADM"];
		
		
		$action = "alterar.php?tabela=denuncia";

		$disabled = true;
		
	}
	else{
		$disabled = false;
		$value_id_denuncia = null;
		$value_situacao = null;
		$selected_id_usuario = null;
		$selected_id_adm = null;
		

		$action = "insere.php?tabela=denuncia";			
	}
	

	$select = "SELECT ID_USUARIO AS value, CONCAT(NOME) AS texto FROM usuario ORDER BY NOME";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_gerente[] = $linha;
	}	

	$select = "SELECT ID_ADM AS value, NOME AS texto FROM administrador ORDER BY NOME";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_localizacao[] = $linha;
	}
	


	$v = array("action"=>"insere.php?tabela=denuncia","method"=>"post");
	$f = new Form($v);

	$v = array("type"=>"number","name"=>"ID_denuncia","placeholder"=>"ID Da DENUNCIA...","value"=>$value_id_denuncia, "disabled"=>$disabled);
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