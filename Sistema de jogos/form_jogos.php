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
	$colunas=array("id_jogo","nome_jogo","class_indicativa","preco","linguagem","avaliacao","empresa");
	$tabelas[0][0]="jogos";
	$tabelas[0][1]=null;
	$ordenacao = null;
	$condicao = $_POST["id"];
	
	$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
	$linha = $stmt->fetch(PDO::FETCH_ASSOC);
	$value_id_jogo = $linha["id_jogo"];
	$value_nome_jogo = $linha["nome_jogo"];
	$value_class_indicativa = $linha["class_indicativa"];
	$value_preco = $linha["preco"];
	$value_linguagem = $linha["linguagem"];
	$value_avaliacao = $linha["avaliacao"];
	$value_empresa = $linha["empresa"];


	
	$action = "altera.php?tabela=jogos";
}
else{
	$action = "insere.php?tabela=jogos";
	$value_id_jogo="";
	$value_nome_jogo="";
	$value_class_indiativa ="";
	$value_preco ="";
	$value_linguagem ="";
	$value_avaliacao ="";
	$value_empresa ="";
	
}

	$v = array("action"=>$action,"method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"number","name"=>"ID_JOGO","placeholder"=>"ID DO JOGO...","value"=>$value_id_jogo);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"NOME_JOGO","placeholder"=>"NOME JOGO...","value"=>$value_JOGO);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"CLASS_INDICATIVA","placeholder"=>"CLASSE INDICATIVA...","value"=>$value_class_indicativa);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"PRECO","placeholder"=>"PRECO...","value"=>$value_preco);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"LINGUAGEM","placeholder"=>"cpf...","value"=>$value_linguagem);
	$f->add_input($v);
	$v = array("type"=>"email","name"=>"AVALIACAO","placeholder"=>"email...","value"=>$value_avaliacao);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"EMPRESA","placeholder"=>"nome...","value"=>$value_empresa);
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
				url: "insere.php?tabela=jogos",
				type: "post",
				data: {
						ID_JOGO: $("input[name='ID_JOGO']").val(),
						NOME_JOGO: $("input[name='NOME_JOGO']").val(),
						CLASS_INDICATIVA: $("input[name='CLASS_INDICATIVA']").val(),
						PRECO: $("input[name='PRECO']").val(),
						LINGUAGEM: $("input[name='LINGUAGEM']").val(),
						AVALIACAO: $("input[name='AVALIACAO']").val(),
						EMPRESA: $("input[name='EMPRESA']").val()
						


					},
					beforeSend: function(d){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("jogo inserido com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("jogo não inserido: Codigo já existente.");
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