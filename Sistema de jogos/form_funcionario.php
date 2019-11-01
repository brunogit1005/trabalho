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
		$tabelas[0][0]="funcionario";
		$tabelas[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_funcionario = $linha["ID_FUNCIONARIO"];
		$value_nome_funcionario = $linha["NOME"];
		$value_id_departamento = $linha["ID_DEPARTAMENTO"];
		$value_sobrenome_funcionario = $linha["SOBRENOME"];
		$value_telefone_funcionario = $linha["TELEFONE"];
		$value_email_funcionario = $linha["EMAIL"];
		$value_data_contratacao_funcionario = $linha["DATA_CONTRATACAO"];
		$selected_id_funcao_funcionario = $linha["ID_FUNCAO"];
		$value_email_funcionario = $linha["EMAIL"];
		$selected_id_gerente_funcionario = $linha["ID_GERENTE"];
		$value_salario_funcionario = $linha["SALARIO"];
		$value_comissao_funcionario = $linha["COMISSAO"];
		$selected_id_departamento_funcionario = $linha["ID_DEPARTAMENTO"];
		$value_id_funcionario = $linha["ID_FUNCIONARIO"];

		
		$action = "alterar.php?tabela=funcionario";

		$disabled = true;
		
	}
	else{
		$disabled = false;
		$value_id_funcionario = null;
		$value_nome_funcionario = null;
		$value_id_departamento = null;
		$value_sobrenome_funcionario = null;
		$value_telefone_funcionario = null;
		$value_email_funcionario = null;
		$value_data_contratacao_funcionario = null;
		$selected_id_funcao_funcionario = null;
		$value_email_funcionario = null;
		$selected_id_funcao_funcionario = null;
		$selected_id_gerente_funcionario = null;
		$value_salario_funcionario = null;
		$value_comissao_funcionario = null;
		$selected_id_departamento_funcionario = null;
		$value_id_funcionario = null;

		$action = "insere.php?tabela=funcionario";			
	}
	
	
	$select = "SELECT ID_FUNCAO AS value, TITULO_FUNCAO AS texto FROM funcao ORDER BY TITULO_FUNCAO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_funcao[] = $linha;
	}	

	$select = "SELECT ID_FUNCIONARIO AS value, CONCAT(SOBRENOME,', ',NOME) AS texto FROM funcionario ORDER BY SOBRENOME, NOME";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_gerente[] = $linha;
	}	

	$select = "SELECT ID_DEPARTAMENTO AS value, NOME_DEPARTAMENTO AS texto FROM departamento ORDER BY NOME_DEPARTAMENTO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_departamento[] = $linha;
	}	



	$v = array("action"=>"insere.php?tabela=funcionario","method"=>"post");
	$f = new Form($v);

	$v = array("type"=>"number","name"=>"ID_FUNCIONARIO","placeholder"=>"ID_FUNCIONARIO...","value"=>$value_id_funcionario, "disabled"=>$disabled);
	$f->add_input($v);

	if($disabled == true){
		array("type"=>"hidden","name"=>"ID_FUNCIONARIO","placeholder"=>"ID_FUNCIONARIO...");

	}
	$v = array("type"=>"text","name"=>"NOME","placeholder"=>"NOME...","value"=>$value_nome_funcionario);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"SOBRENOME","placeholder"=>"SOBRENOME...", "value"=>$value_sobrenome_funcionario);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"EMAIL","placeholder"=>"EMAIL...","value"=>$value_email_funcionario);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"TELEFONE","placeholder"=>"TELEFONE...","value"=>$value_telefone_funcionario);
	$f->add_input($v);
	$v = array("type"=>"date","label"=>"Data Contratação: ", "name"=>"DATA_CONTRATACAO","placeholder"=>"DATA CONTRATAÇÃO...","value"=>$value_data_contratacao_funcionario);
	$f->add_input($v);
	
	$v = array("name"=>"ID_FUNCAO","label"=>"Função","selected"=>$selected_id_funcao_funcionario);
	$f->add_select($v,$matriz_funcao);
	
	$v = array("type"=>"number","name"=>"SALARIO","placeholder"=>"SALÁRIO...","value"=>$value_salario_funcionario);
	$f->add_input($v);

	$v = array("type"=>"number","name"=>"COMISSAO","placeholder"=>"COMISSÃO (DE 0 A 50%)...","value"=>$value_comissao_funcionario);
	$f->add_input($v);	

	$v = array("name"=>"ID_GERENTE","label"=>"Gerente","selected"=>$selected_id_gerente_funcionario);
	$f->add_select($v,$matriz_gerente);

	$v = array("name"=>"ID_DEPARTAMENTO","label"=>"Departamento","selected"=>$selected_id_departamento_funcionario);
	$f->add_select($v,$matriz_departamento);

	$v = array("texto"=>"ENVIAR");
	$f->add_button($v);	
?>

<h3>Formulário - Inserir Funcionário</h3>
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
				url: "insere.php?tabela=funcionario",
				type: "post",
				data: {
						ID_FUNCIONARIO: $("input[name='ID_FUNCIONARIO']").val(),
						NOME: $("input[name='NOME']").val(),
						SOBRENOME: $("input[name='SOBRENOME']").val(),
						EMAIL: $("input[name='EMAIL']").val(),
						TELEFONE: $("input[name='TELEFONE']").val(),
						DATA_CONTRATACAO: $("input[name='DATA_CONTRATACAO']").val(),
						ID_FUNCAO: $("select[name='ID_FUNCAO']").val(),
						SALARIO: $("input[name='SALARIO']").val(),
						COMISSAO: $("input[name='COMISSAO']").val(),
						ID_GERENTE: $("select[name='ID_GERENTE']").val(),
						ID_DEPARTAMENTO: $("input[name='ID_DEPARTAMENTO']").val()
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