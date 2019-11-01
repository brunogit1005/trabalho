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
	$colunas=array("id_adm","telefone","cidade","rg","cpf","email","nome","data_nasc");
	$tabelas[0][0]="adiministrador";
	$tabelas[0][1]=null;
	$ordenacao = null;
	$condicao = $_POST["id"];
	
	$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
	$linha = $stmt->fetch(PDO::FETCH_ASSOC);
	$value_id_adm = $linha["id_adm"];
	$value_telefone = $linha["telefone"];
	$value_cidade = $linha["cidade"];
	$value_rg = $linha["rg"];
	$value_cpf = $linha["cpf"];
	$value_email = $linha["email"];
	$value_nome = $linha["nome"];
	$value_data_nasc = $linha["data_nasc"];
	$action = "altera.php?tabela=administrador";
}
else{
	$action = "insere.php?tabela=administrador";
	$value_id_adm="";
	$value_telefone="";
	$value_cidade ="";
	$value_rg ="";
	$value_cpf ="";
	$value_email ="";
	$value_nome ="";
	$value_data_nasc ="";
	
}

	$v = array("action"=>$action,"method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"number","name"=>"ID_ADM","placeholder"=>"ID DO ADM...","value"=>$value_id_adm);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"TELEFONE","placeholder"=>"telefone...","value"=>$value_telefone);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"CIDADE","placeholder"=>"CIDADE...","value"=>$value_cidade);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"RG","placeholder"=>"RG...","value"=>$value_rg);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"CPF","placeholder"=>"cpf...","value"=>$value_cpf);
	$f->add_input($v);
	$v = array("type"=>"email","name"=>"email","placeholder"=>"email...","value"=>$value_email);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"nome","placeholder"=>"nome...","value"=>$value_nome);
	$f->add_input($v);
	$v = array("type"=>"date","name"=>"data_nasc","placeholder"=>"data de nascimento...","value"=>$value_data_nasc);
	$f->add_input($v);	
	$v = array("type"=>"button","texto"=>"ENVIAR");
	$f->add_button($v);	
?>

<h3>Formulário - Inserir Região</h3>
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
				url: "insere.php?tabela=administrador",
				type: "post",
				data: {
						ID_ADM: $("input[name='ID_ADM']").val(),
						TELEFONE: $("input[name='TELEFONE']").val(),
						CIDADE: $("input[name='CIDADE']").val(),
						RG: $("input[name='RG']").val(),
						CPF: $("input[name='CPF']").val(),
						EMAIL: $("input[name='EMAIL']").val(),
						NOME: $("input[name='NOME']").val(),
						DATA_NASC: $("input[name='DATA_NASC']").val()


					},
					beforeSend: function(d){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("administrador inserida com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("adiministrador não inserida: Codigo já existente.");
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