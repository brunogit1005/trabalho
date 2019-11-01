<?php

	include("../classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	
	require_once("../classeForm/InterfaceExibicao.php");
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeOption.php");
	require_once("../classeForm/classeSelect.php");
	require_once("../classeForm/classeButton.php");
	require_once("../classeForm/classeForm.php");

	include("conexao.php");
	
		if(isset($_POST["id"])){
			require_once("classeControllerBD.php");
			$c = new ControllerBD($conexao);
			$colunas = array("*");
			$tabelas[0][0]="pais";
			$tabelas[0][1]=null;
			$ordenacao = null;
			$condicao = $_POST["id"];
			$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
			$linha = $stmt->fetch(PDO::FETCH_ASSOC);
			$value_id_pais = $linha["ID_PAIS"];
			$value_nome_pais = $linha["NOME_PAIS"];
			$value_id_regiao = $linha["ID_REGIAO"];
			
			$action = "alterar.php?tabela=pais";
			
		}
		else{
			$value_id_pais =null;
			$value_nome_pais =null;
			$value_id_regiao =null;
			$action = "insere.php?tabela=pais";			
		}
	
	

	$select = "SELECT ID_REGIAO AS value, NOME_REGIAO AS texto FROM regiao ORDER BY NOME_REGIAO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz[] = $linha;
	}	
	

	$v = array("action"=>"insere.php?tabela=pais","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"text","name"=>"ID_PAIS","placeholder"=>"SIGLA...","value"=>$value_id_pais);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"NOME_PAIS","placeholder"=>"NOME DO PAÍS...","value"=>$value_nome_pais);
	$f->add_input($v);
	
	$v = array("name"=>"ID_REGIAO","selected"=>$value_id_regiao);
	$f->add_select($v,$matriz);
	
	
	$v = array("type"=>"button","texto"=>"ENVIAR");
	$f->add_button($v);	
?>

<h3>Formulário - Inserir País</h3>
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
				url: "insere.php?tabela=pais",
				type: "post",
				data: {
						ID_PAIS: $("input[name='ID_PAIS']").val(),
						NOME_PAIS: $("input[name='NOME_PAIS']").val(),
						ID_REGIAO: $("select[name='ID_REGIAO']").val()
					},
					beforeSend: function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						console.log(d);
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Região inserida com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Pais não inserida: Codigo já existente.");
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