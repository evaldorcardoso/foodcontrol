<?php
/* Configurações com Banco de Dados*/
include_once '../classes/ConnClass.php';
$connClass = new ConnClass();	
$link = mysql_connect($connClass->server,$connClass->usuario,$connClass->senha) or die ('Ops! Sem conexão com o servidor');
mysql_select_db($connClass->banco) or die ('Ops! Banco de dados não encontrado');
mysql_set_charset('utf8',$link);
?>