<?php
//require_once('config.php');
include_once "pretty_json.php";
include_once "../classes/crudClass.php";

//funcao desejada
if(isset($_GET['funcao']))
{
	ini_set("memory_limit","100M");
	header('Content-type: application/json');


$funcao=$_GET['funcao'];

switch ($_GET['funcao']) {
	case 'pegar_mesas':
		pegar_mesas();
		break;
	case 'pegar_pedidos':
		if(isset($_GET['id_mesa']))
			pegar_pedidos_mesa($_GET['id_mesa']);
		else
			pegar_pedidos();
		break;
	case 'novo_pedido':
		novo_pedido($_GET['usuario_id'],$_GET['mesa_id'],$_GET['cliente_id'],$_GET['obs']);
		break;
	case 'novo_cliente':
		novo_cliente($_GET['nome'],$_GET['endereco'],$_GET['cidade'],$_GET['telefone']);
		break;
	case 'edita_pedido':
		edita_pedido($_GET['id'],$_GET['mesa_id'],$_GET['cliente_id'],$_GET['obs']);
		break;
	case 'pegar_itens':
		pegar_itens();
		break;
	case 'pegar_itens_pedido':
		pegar_itens_pedido($_GET['pedido_id']);
		break;
	case 'pegar_pedido':
		pegar_pedido($_GET['id']);
		break;
	case 'pegar_pedido_editar':
		pegar_pedido_editar($_GET['id']);
		break;
	case 'salvar_pedido':
		salvar_pedido($_GET['pedido_id']);
		break;
	case 'excluir_item_pedido':
		excluir_item_pedido($_GET['id']);
		break;
	case 'logar':
		logar($_GET['login'],$_GET['senha']);
		break;
	case 'imprimir_comanda':
		imprimir_comanda($_GET['pedido_id'],$_GET['categoria']);
		break;
	case 'pegar_clientes':
		pegar_clientes();
		break;
	case 'tipo_venda':
		tipo_venda();
		break;
	case 'pegar_licenca':
		pegar_licenca($_GET['serie']);
		break;
	default:
		# code...
		break;
}
}

function db_connect() 
{
	        // Define connection as a static variable, to avoid connecting more than once
	        static $connection;
	        // Try and connect to the database, if a connection has not been established yet
	        if(!isset($connection)) {
	            // Load configuration as an array. Use the actual location of your configuration file
	            include_once('../classes/Ini.class.php');
    			$config = new IniParser( '../config.ini' );
	            $connection = mysqli_connect($config->getValue('server'),$config->getValue('usuario'),$GLOBALS['id_cliente'],$config->getValue('banco'));
	            mysqli_query($connection,"SET character_set_results=utf8");
	        }
	        // If connection was not successful, handle the error
	        if($connection === false) {
	            // Handle error - notify administrator, log to a file, show an error screen, etc.
	            return mysqli_connect_error();
	        }
	        return $connection;
}

function pegar_mesas()
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT m.id,m.descricao, (select count(id) 
								from pedido where mesa_id=m.id and situacao=0) as status
								from mesa m left join
								pedido p on m.id=p.mesa_id
								group by m.id
								order by descricao");
			$mesas = array();
			if(mysqli_num_rows($rs)>0)
			{
				while($array_ = mysqli_fetch_array($rs))
				{
					$mesas["id"]= $array_['id'];
					$mesas["descricao"]= $array_['descricao'];
					if($array_['status']>0)
						$array_['status']="1";
					$mesas["status"]=$array_['status'];
					//codifica para utf-8
					//$cursos["fullname"]=utf8_encode($array_course['fullname']);
					array_push($info, $mesas);
				}
			}
				//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_pedidos_mesa($idmesa)
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT p.id,p.mesa_id,p.usuario_id,p.valor,p.data_pedido,p.nome,p.obs,u.login,c.nome as cliente 
						FROM pedido p left join cliente c on p.cliente_id=c.id 
						left join usuario u on p.usuario_id=u.id
						WHERE mesa_id=".$idmesa." AND
							situacao='false'");
			$pedidos = array();
			if(mysqli_num_rows($rs)>0)
			{
				while($array_ = mysqli_fetch_array($rs))
				{
					$pedidos["id"]= $array_['id'];
					$pedidos["nome"]= html_entity_decode($array_['cliente']);
					if(($array_["cliente"]=="")||($array_["cliente"]=="#"))
						$pedidos["nome"]= html_entity_decode($array_['obs']);
					$data=date_create($array_['data_pedido']);
					$pedidos["data_pedido"]= date_format($data,"d/m/Y");
					//codifica para utf-8
					$pedidos["obs"]= html_entity_decode($array_['obs']);
					//$cursos["fullname"]=utf8_encode($array_course['fullname']);
					array_push($info, $pedidos);
				}
			}
				//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_pedidos()
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT p.id,p.usuario_id,p.valor,p.data_pedido,p.nome,p.obs,u.login,c.nome as cliente 
						FROM pedido p left join cliente c on p.cliente_id=c.id 
						left join usuario u on p.usuario_id=u.id
						WHERE situacao='false'");
			$pedidos = array();
			if(mysqli_num_rows($rs)>0)
			{
				while($array_ = mysqli_fetch_array($rs))
				{
					$pedidos["id"]= $array_['id'];
					$pedidos["nome"]= html_entity_decode($array_['cliente']);
					if(($array_["cliente"]=="")||($array_["cliente"]=="#"))
						$pedidos["nome"]= html_entity_decode($array_['obs']);
					$data=date_create($array_['data_pedido']);
					$pedidos["data_pedido"]= date_format($data,"d/m/Y");
					//codifica para utf-8
					$pedidos["obs"]= html_entity_decode($array_['obs']);
					//$cursos["fullname"]=utf8_encode($array_course['fullname']);
					array_push($info, $pedidos);
				}
			}
				//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function novo_pedido($usuario_id,$mesa_id,$cliente_id,$obs)
{
	$cClass=new crudClass();
	//array que guarda os dados
	$info = array();
	$t=time();//hora atual
	if($mesa_id=='')
		$campos = array('usuario_id' =>$usuario_id,'cliente_id' => $cliente_id,'data_pedido' => date("Y-m-d",$t),'situacao' => '0','valor' => '0','obs' => $obs);
	else
		$campos = array('usuario_id' =>$usuario_id, 'mesa_id' =>$mesa_id ,'cliente_id' => $cliente_id,'data_pedido' => date("Y-m-d",$t),'situacao' => '0','valor' => '0','obs' => $obs);
	/*if($cliente_id=='')
		$campos = array('usuario_id' =>$usuario_id, 'mesa_id' =>$mesa_id ,'data_pedido' => date("Y-m-d",$t),'situacao' => '0','valor' => '0','obs' => $obs);
	else
		$campos = array('usuario_id' =>$usuario_id, 'mesa_id' =>$mesa_id ,'cliente_id' => $cliente_id,'data_pedido' => date("Y-m-d",$t),'situacao' => '0','valor' => '0','obs' => $obs);*/
	if($cClass -> inserir($campos,'pedido'))
	{
		$id=$cClass -> pegaUltimoIdInserido();
		$pedido = array();
		$pedido['id']=$id;
		$pedido['nome']='';
		array_push($info,$pedido);
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function novo_cliente($nome,$endereco,$cidade,$telefone)
{
	$cClass=new crudClass();
	//array que guarda os dados
	$info = array();
	$campos = array('nome' =>$nome, 'endereco' =>$endereco ,'cidade' => $cidade,'telefone' => $telefone);
	if($cClass -> inserir($campos,'cliente'))
		echo 'OK';
	else
		echo 'erro';
}

function tipo_venda()
{
	include_once('../classes/Ini.class.php');
    $config = new IniParser( '../config.ini' );
    echo $config->getValue('modo_venda');
}

function edita_pedido($id,$mesa_id,$cliente_id,$obs)
{
	$cClass=new crudClass();
	if($cliente_id=="")
		$campos = array('id' => $id,'mesa_id' =>$mesa_id ,'obs' => $obs);
	else
		$campos = array('id' => $id,'mesa_id' =>$mesa_id ,'cliente_id' => $cliente_id,'obs' => $obs);
	//print_r($campos);
	if($cClass -> acaoCrud($campos,'pedido','update','id',$id))
		echo 'OK';
	else
		echo 'erro';
}

function pegar_itens()
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT * FROM item_cardapio WHERE item_tele=0 and ativo=1 or item_tele=2");
	$itens = array();
	if(mysqli_num_rows($rs)>0)
	{
		while($array_ = mysqli_fetch_array($rs))
		{
			$itens["id"]= $array_['id'];
			$itens["descricao"]= $array_['descricao'];
			$itens["categoria"]= $array_['categoria'];
			//codifica para utf-8
			//$itens["descricao"]=utf8_encode($array_['descricao']);
			$itens["descricao"]=html_entity_decode($array_['descricao']);
			array_push($info, $itens);
		}
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_itens_pedido($idpedido)
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT pic.id,ic.descricao,pic.quantidade
						FROM item_cardapio ic INNER JOIN pedido_has_item_cardapio pic
						ON ic.id=pic.item_cardapio_id
						WHERE pic.pedido_id=".$idpedido);
	$itens = array();
	if(mysqli_num_rows($rs)>0)
	{
		while($array_ = mysqli_fetch_array($rs))
		{
			$itens["id"]= $array_['id'];
			$itens["descricao"]= $array_['descricao'];
			$itens["quantidade"]= $array_['quantidade'];
			//codifica para utf-8
			//$itens["descricao"]=utf8_encode($array_['descricao']);
			$itens["descricao"]=html_entity_decode($array_['descricao']);
			array_push($info, $itens);
		}
	}


	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_pedido($idpedido)
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"select p.id,m.descricao,p.valor,p.obs,c.nome as cliente
									from pedido p left join
									mesa m on p.mesa_id=m.id left join 
									cliente c on p.cliente_id=c.id
									where p.id=$idpedido");
	$itens = array();
	if(mysqli_num_rows($rs)>0)
	{
		while($array_ = mysqli_fetch_array($rs))
		{
			$itens["id"]= $array_['id'];
			$itens["cliente"]=html_entity_decode($array_['cliente']);
			$itens["mesa"]= $array_['descricao'];
			$itens["valor"]= $array_['valor'];
			$itens["obs"]=html_entity_decode($array_['obs']);
			array_push($info, $itens);
		}
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_pedido_editar($idpedido)
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"select p.id,p.obs,c.nome as cliente,c.id as cliente_id,m.id as mesa_id
									from pedido p inner join
									mesa m on p.mesa_id=m.id left join 
									cliente c on p.cliente_id=c.id
									where p.id=$idpedido");
	$itens = array();
	if(mysqli_num_rows($rs)>0)
	{
		while($array_ = mysqli_fetch_array($rs))
		{
			$itens["id"]= $array_['id'];
			$itens["cliente"]=html_entity_decode($array_['cliente']);
			$itens["cliente_id"]= $array_['cliente_id'];
			$itens["mesa_id"]= $array_['mesa_id'];
			$itens["obs"]=html_entity_decode($array_['obs']);
			array_push($info, $itens);
		}
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function salvar_pedido($pedido_id)
{
	$campos=array();
	$itens=array();
	$t=time();//hora atual
	$i=1;

	while (isset($_GET['id'.$i])) 
	{
		$itens['item_cardapio_id']=$_GET['id'.$i];
		$itens['pedido_id']=$pedido_id;
		$itens['quantidade']=$_GET['quantidade'.$i];
		$itens['obs']=$_GET['obs'.$i];
		$itens['situacao']='0';
		$itens['hora']=date("Y-m-d H:i:s",$t);
		$itens['quantidade_entregue']="0";
		$itens['quantidade_paga']="0";
		array_push($campos, $itens);
		$i++;
	}
	$cClass=new crudClass();
	foreach ($campos as $value) 
	{
		$cClass -> inserir($value,'pedido_has_item_cardapio');
	}
	$cClass->listarItensPedido($pedido_id);
	if(0<>mysqli_num_rows($cClass->getconsulta()))
	{
		$valortotalpedido=0;
		while($array_ = mysqli_fetch_array($cClass->getconsulta()))
		{
			$valortotalpedido+=($array_['quantidade']*$array_['valor']);
		}
		//echo $valortotalpedido;
		if($cClass->alterar("valor",$valortotalpedido,'pedido','id',$pedido_id))
			echo 'OK';//OK
		else
			echo 'erro';
	}
}

function excluir_item_pedido($item_id)
{
	
	$cClass=new crudClass();
	if($cClass -> deletar('pedido_has_item_cardapio','id',$item_id))
	{
		$cClass->listarItensPedido($pedido_id);
		if(0<>mysqli_num_rows($cClass->getconsulta()))
		{
			$valortotalpedido=0;
			while($array_ = mysqli_fetch_array($cClass->getconsulta()))
			{
				$valortotalpedido+=($array_['quantidade']*$array_['valor']);
			}
			//echo $valortotalpedido;
			if($cClass->alterar("valor",$valortotalpedido,'pedido','id',$pedido_id))
				echo 'OK';//OK
			else
				echo 'erro';
		}
		else
		{
			if($cClass->alterar("valor","0",'pedido','id',$_POST['pedido_id']))
				echo 'OK';//OK
			else
				echo 'erro';
		}
	}
	else
		echo 'erro';
}

function imprimir_comanda($idpedido,$categoria)
{
	include_once '../nfiscal/imprime_nao_fiscal.php';
	imprime_pedido_categoria($idpedido,$categoria);
}

function logar($login, $passwor)
{
	$cClass = new crudClass();	
	$cClass -> pesquisarTabela('usuario','login',$login);
	//array que guarda os dados
	$info = array();
	$usuarios=array();
	if(0!=mysqli_num_rows($cClass->getconsulta()))
	{
		$array_=mysqli_fetch_assoc($cClass->getconsulta());
		$campos = array('senha' => $passwor,'reseta_senha' => '0');
		if($array_['reseta_senha']=='1')
		{
			$cClass -> acaoCrud($campos,'usuario','update','id',$array_['id']);
			$cClass -> pesquisarTabela('usuario','login',$login);
			if($array_['senha']==md5($passwor))
			{
				$usuarios['id']=$array_['id'];
				$usuarios['login']=$array_['login'];
				$usuarios['senha']=$array_['senha'];
				$usuarios['nivel']=$array_['nivel'];
				array_push($info, $usuarios);
			}
		}
		else
		{
			if($array_['senha']==md5($passwor))
			{
				$usuarios['id']=$array_['id'];
				$usuarios['login']=$array_['login'];
				$usuarios['senha']=$array_['senha'];
				$usuarios['nivel']=$array_['nivel'];
				array_push($info, $usuarios);
			}
		}
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_clientes()
{
	$connection = db_connect();
	//array que guarda os dados
	$info = array();
	$rs = mysqli_query($connection,"SELECT * FROM cliente");
	$clientes = array();
	if(mysqli_num_rows($rs)>0)
	{
		//$itens["id"]= '';
		//$itens["descricao"]= '';
		//$itens["categoria"]= '1';
		//array_push($info, $itens);
		//$itens["id"]= '';
		//$itens["descricao"]= '';
		//$itens["categoria"]= '2';
		//array_push($info, $itens);
		while($array_ = mysqli_fetch_array($rs))
		{
			$clientes["id"]= $array_['id'];
			$clientes["nome"]= html_entity_decode($array_['nome']);
			array_push($info, $clientes);
		}
	}
	//chama a função para montar o JSON e mostra na tela
	print_r(pretty_json(json_encode($info)));
}

function pegar_licenca($serie)
{
	$connection = db_connect();
	$res=mysqli_query($connection,"SELECT * FROM licenca");
	$aux=false;
	if(0<>mysqli_num_rows($res))
	{
		while ($array_=mysqli_fetch_array($res)) 
		{
			$codigo=base64_decode($array_['codigo']);
			$p_barra1=strpos($codigo, '/');//posicao da barra 1
			$p_barra2=strripos($codigo, '/');//posicao da barra 2
			$idUsuario=substr($codigo, 0,$p_barra1);
			$data=substr($codigo, $p_barra2+1);//pega o valor depois do ultimo '/' encontrado
			$data_now=time();
			$mac=substr($codigo, $p_barra1+1,($p_barra2-$p_barra1)-1);
			if(strcmp($mac, $serie)==0)
			{
				$aux=true;
				if(strtotime(date("d-m-Y",$data_now))<=strtotime(date("d-m-Y",$data)))
					echo 'OK';
				else
					echo 'erro';
			}
		}
		if(!$aux)
			echo 'erro';
	}
	else
		echo 'erro';
}

?>


