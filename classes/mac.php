<?php

//Classe que pega o MAC da placa de Rede...
class Mac{
	//Variaveis de acesso
	public $saida;
	
	//constroi a função ao instanciar a classe
	//__construct e um nome de função do proprio php
	//serve para executar os parametros assim que voce instacia a classe...
	public function __construct(){
		//executa comando externo escapando o comando shell para evitar execução de comandos arbritários. 
		if($_SERVER['HTTP_HOST']!='localhost')
			$this->saida=$_SERVER['HTTP_HOST'];
		else
			exec(escapeshellcmd("ipconfig/all"), $this->saida);
		
	}
	//metodo de recuperação de informações
	public function MacId(){
		if($_SERVER['HTTP_HOST']!='localhost')
			return $_SERVER['HTTP_HOST'];
		else
		{
			//variavel separando os dados retornados
			//caso não utilize o explode a função retornara 
			//Endereço Físico. . . . . . . . . . . .: (endereço)
			//queremos apenas o endereço MAC ID da placa de rede do usuário....
			$dt = explode(":",$this->saida[13]);//pega a 13º saída do array retornado pelo EXEC 
			//retorna a separação(explode) com a segunda saida (1), a primeira e o nome  (0)
			$mac=$dt[1];
			$mac=ltrim($mac);
			$mac=rtrim($mac);
			return $mac;
		}
	}
	
	
}


/*
Exemplo de uso.
*/
//instanciando a classe
//$pegamac = new Mac;// << define a classe com uma variavel...voce pode denominar qualquer nome de variavel... 
//lembre-se de manter as letras maiúsculas da classe e do método ou função como queira chamar...
//echo"Mac do pc: ".$pegamac->MacId();//retorna um eco e adquire a instancia e lança o metodo MacId()
//utilize o $pegamac->Macid(); onde decejar (obvio que voce instancia a classe antes como expliquei acima..)
//hehe ta ai um exemplozinho idiota de como usar classe e de como usar o exec e de pegar o MAC... ui diliça 3 em 1 em kkkkk

?>