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
		$colunas = array("id_usuario","nome","data_nasc","rg","cpf","cidade", "endereco", "telefone", "email", "cod_denuncia", "cod_compra");
		$tabela[0][0]="usuario";
		$tabela[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		$stmt = $c->selecionar($colunas,$tabela,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_usuario= $linha["id_usuario"];
		$value_nome = $linha["nome"];
		$value_data_nasc = $linha["data_nasc"];
		$value_rg= $linha["rg"];
		$value_cpf= $linha["cpf"];
		$value_cidade= $linha["cidade"];
		$value_endereco= $linha["endereco"];
		$value_telefone= $linha["telefone"];
		$value_email= $linha["email"];
        $value_cod_denuncia= $linha["cod_denuncia"];
        $value_cod_compra= $linha["cod_compra"];
		$action = "altera.php?tabela=usuario";
	}
	else{
        $action = "altera.php?tabela=usuario";
		$value_id_usuario = "";
		$value_nome = "";
		$value_data_nasc = "";
		$value_telefone = "";
		$value_rg = "";
		$value_cpf = "";
		$value_cidade = "";
		$value_endereco = "";
		$value_telefone = "";
        $value_email = "";
        $value_cod_denuncia = "";
        $value_cod_compra = "";
		$action = "insere.php?tabela=usuario";			
	}
	
	$select = "SELECT ID_DENUNCIA AS value, DENUNCIA AS texto FROM denuncia ORDER BY ID_DENUNCIA";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_denuncia[] = $linha;
	}	

	$select = "SELECT ID_COMPRA AS value, COMPRA AS texto FROM COMPRA ORDER BY ID_COMPRA";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_compra[] = $linha;
	}	

	$v = array("action"=>"insere.php?tabela=funcao","method"=>"post");
	$f = new Form($v);
	
	$v = array("type"=>"number","name"=>"ID_USUARIO","placeholder"=>"ID DO USUARIO...","value"=>$value_id_usuario);
	$f->add_input($v);
	$v = array("type"=>"text","name"=>"NOME","placeholder"=>"NOME...","value"=>$value_nome);
	$f->add_input($v);
	$v = array("type"=>"date","name"=>"DATA_NASC","placeholder"=>"DATA DE NASCIMENTO...","value"=>$value_data_nasc);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"RG","placeholder"=>"RG...","value"=>$value_rg);
	$f->add_input($v);
	$v = array("type"=>"number","name"=>"CPF","placeholder"=>"CPF...","value"=>$value_cpf);
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"CIDADE","placeholder"=>"CIDADE...","value"=>$value_cidade);
    $f->add_input($v);
    $v = array("type"=>"text","name"=>"ENDERECO","placeholder"=>"ENDERECO...","value"=>$value_telefone);
    $f->add_input($v);
    $v = array("type"=>"number","name"=>"TELEFONE","placeholder"=>"TELEFONE...","value"=>$value_email);
    $f->add_input($v);
    $v = array("type"=>"email","name"=>"EMAIL","placeholder"=>"EMAIL..."),"value"=>$value_rg;
	$f->add_input($v);
	
	$v = array("name"=>"ID_DENUNCIA","label"=>"Denuncia");
	$f->add_select($v,$matriz_denuncia);
    
    $v = array("name"=>"ID_COMPRA","label"=>"Compra");
    $f->add_select($v,$matriz_compra);
	$v = array("texto"=>"ENVIAR");
    $f->add_button($v);	
?>

<h3>Formulário - Inserir Usuário</h3>

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
                    ID_USUARIO: $("input[name='ID_USUARIO']").val(),
						NOME: $("input[name='NOME']").val(),
						DATA_NASC: $("input[name='DATA_NASC']").val(),
						RG: $("input[name='RG']").val(),
						CPF: $("input[name='CPF']").val(),
						CIDADE: $("input[name='CIDADE']").val(),
						ENDERECO: $("select[name='ENDERECO']").val(),
						TELEFONE: $("input[name='TELEFONE']").val(),
						EMAIL: $("input[name='EMAIL']").val(),
						ID_DENUNCIA: $("select[name='ID_DENUNCIA']").val(),
						ID_COMPRA: $("input[name='ID_COMPRA']").val()
					},
					beforeSend: function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Usuario inserido com sucesso.");
							$("#status").css("color","purple");

						}
						else
						{
							$("#status").html("Usuario não inserido: Codigo já existente.");
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