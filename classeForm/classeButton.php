<?php
	require_once("InterfaceExibicao.php");
	class Button implements Exibicao{
		private $texto;
		private $type;

		public function __construct($vetor){
			$this->texto = $vetor["texto"];
			if(isset($vetor["type"])){
				$this->type=$vetor["type"];
			}
		}
		
		public function exibe(){
			echo "<button ";
			if($this->type!=null){
				echo "type='$this->type'";
			}
			echo ">$this->texto</button>";
		}
		
	}
?>