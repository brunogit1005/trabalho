<?php
include("../classeLayout/classeCabecalhoHTML.php");
include("cabecalho.php");

include("conexao.php");

if(!empty($_POST){

    include ("classeControllerBD.php");

    $c = new ControllerBD($conexao);
    $c->alterar($_POST, $_GET["tabela"])
        or die["Erro ao alterar".$_GET["tabela"]);
        echo $_GET["tabela"]." alterada com sucesso";

}
else
{
    header("location: form_".$_GET["tabela"].".php");
}

?>