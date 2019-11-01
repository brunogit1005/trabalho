<?php
	require_once("InterfaceExibicao.php");
	
	class Input implements Exibicao{
		private $type;
		private $name;
		private $placeholder;
		private $value;
		//private $label;
		private $disabled=false;
		
		public function __construct($vetor){
			$this->type=$vetor["type"];
			$this->name=$vetor["name"];			
			$this->value=$vetor["value"];
			if(isset($vetor["placeholder"])){
				$this->placeholder=$vetor["placeholder"];
			}
			//$this->label=$vetor["label"];
			if(isset($vetor["disabled"])){
				$this->disabled = $vetor["disabled"];
			}
			
		}
		
		public function exibe(){
			echo 
			"<input type='$this->type'
					name='$this->name' value='$this->value' ";
			if($this->placeholder!=null){
				echo "placeholder='$this->placeholder' ";
			}
			if($this->disabled){
				echo "disabled ";
			}
			echo " />";
		}
		
	}
?>