<?php
ini_set("memory_limit","100M");
header('Content-type: application/json');

require_once('config.php');
//include "simple_html_dom.php";
include "pretty_json.php";

//username usuario
$login= $_GET['login'];
//senha usuario
$senha=$_GET['senha'];

//adiciona junto a criptografia para decodificar a senha
//encontrado no arquivo config.php - linha 25
$senha.='EoL}qy%eAO/t,EBFY%(.[?rHId(}q+t';
$info = array();

$rs = mysqli_query("SELECT id,firstname,lastname,username FROM mdl_user WHERE username='$login' AND password=MD5('$senha')");
		$alunos = array();
		if(mysqli_num_rows($rs)>0)
		{
			while($array_user = mysqli_fetch_array($rs))
			{
				$alunos["id"]= $array_user['id'];
				$alunos["username"]=$array_user['username'];
				$alunos["firstname"]= $array_user['firstname'];
				$alunos["lastname"]=$array_user['lastname'];
				//$alunos["lastname"]=utf8_encode($array_user['lastname']);
				array_push($info, $alunos);
			}
		}
print_r(pretty_json(json_encode($info)));
?>