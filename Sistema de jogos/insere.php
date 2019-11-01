<?php
	//include("../classeLayout/classeCabecalhoHTML.php");
	//include("cabecalho.php");
	
	
include("conexao.php");



if(!empty($_POST)){

	include("classeControllerBD.php");
	
	$c = new ControllerBD($conexao);
	
	$c->inserir($_POST,$_GET["tabela"]) or die("0");
	echo "1";
	//print_r($c->conexao->errorInfo()));"
	
}
/*else{
	header("location: form_pais.php");
}*/
?>