<?php
	include("../classeLayout/classeCabecalhoHTML.php");
	include("cabecalho.php");
	include("../classeLayout/classeTabela.php");
	
	include("conexao.php");
	include("classeControllerBD.php");
	
	include("configuracoes_listar.php");
	
	$c = new ControllerBD($conexao);
	
	$r = $c->selecionar($colunas,$t,null,null);
	
	while($linha = $r->fetch(PDO::FETCH_ASSOC)){
		$matriz[] = $linha;
	}
	
	$t = new Tabela($matriz,$t[0][0]);
	$t->exibe();

?>