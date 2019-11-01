<?php

	$c = new CabecalhoHTML();
	$v = array(				
				"administrador"=>"administrador",
				"pais"=>"País",
				"localizacao"=>"Localização",
				"departamento"=>"Departamento",
				"funcao"=>"Função",
				"funcionario"=>"Funcionário",
				"historico_funcoes"=>"Histórico de Funções dos Funcionários"
				);
				
	$c->add_menu($v);
	$c->exibe();

?>