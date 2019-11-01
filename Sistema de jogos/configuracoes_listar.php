<?php

if(isset($_GET["t"])){

	if($_GET["t"]=="administrador"){
		
		$colunas = array(   "id_adm as ID",
							"telefone as 'telefone'",
							"cidade as 'cidade'",
							"rg as 'rg'",
							"cpf as 'cpf'",
							"email as 'email'",
							"nome as 'nome'",
							"data_nasc as 'data_nasc'",
								);				
				$t[0][0] = "administrador";
				$t[0][1] = null;
	}
	
	else if($_GET["t"]=="pais"){
		
		$colunas = array(   "id_pais as ID",
									"Nome_pais as 'País'",
									"Nome_regiao as 'Região'");				
				$t[0][0] = "pais";
				$t[0][1] = "regiao";
	}
	
	else if($_GET["t"]=="localizacao"){
		
		$colunas = array(   "id_localizacao as ID",
									"ENDERECO as 'ENDEREÇO'",
									"CEP as 'CEP'",
									"CIDADE as 'CIDADE'",
									"ESTADO as 'ESTADO'",
									"NOME_PAIS as 'PAÍS'",
									"NOME_REGIAO as 'REGIÃO'"
									);				
				$t[0][0] = "localizacao";
				$t[0][1] = "pais";
				$t[1][0] = "pais";
				$t[1][1] = "regiao";
	}
	
	else if($_GET["t"]=="funcao"){
		
		$colunas = array(   "id_funcao as ID",
							"titulo_funcao as 'Função'",
							"salario_minimo as 'Salário Mínimo'",
							"salario_maximo as 'Salário Máximo'");				
				$t[0][0] = "funcao";
				$t[0][1] = null;
	}
	
	else if($_GET["t"]=="funcionario"){
		
		$colunas = array(  "funcionario.id_funcionario as ID",						   
							"funcionario.nome as 'NOME'",
							"funcionario.sobrenome as 'SOBRENOME'",
							"funcionario.EMAIL as 'EMAIL'",
							"funcionario.TELEFONE as 'TELEFONE'",
							"funcionario.DATA_CONTRATACAO as 'DATA CONTRATAÇÃO'",
							"funcionario.SALARIO as 'SALÁRIO'",
							"funcionario.COMISSAO as 'COMISSÃO'",
							"funcao.TITULO_FUNCAO as 'FUNÇÃO'",
							"gerente.nome as 'NOME GERENTE'"
							);				
				$t[0][0] = "funcionario";
				$t[0][1] = "gerente";
				$t[1][0] = "funcionario";
				$t[1][1] = "funcao";
	}	


	else if($_GET["t"]=="departamento"){
			$colunas = array(   "id_departamento as ID",
									"Nome_Departamento AS 'Nome do Departamento'",
									"Endereco as 'Endereço'",
									"CEP",
									"Cidade",
									"Estado",
									"Nome_pais as 'País'",
									"Nome_regiao as 'Região'");
				
				$t[0][0] = "departamento";
				$t[0][1] = "localizacao";
				$t[1][0] = "localizacao";
				$t[1][1] = "pais";
				$t[2][0] = "pais";
				$t[2][1] = "regiao";
	}
	
}
?>