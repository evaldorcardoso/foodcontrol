<?php
/*crudClass 
	v. 2.0
*/
	//VERSÃO DO SISTEMA//
	$GLOBALS['versao']='1.2.2.0';
	$GLOBALS['id_cliente']='vertrigo';

	class crudClass {

		public function db_connect() 
		{

	        // Define connection as a static variable, to avoid connecting more than once
	        static $connection;
	        // Try and connect to the database, if a connection has not been established yet

	        if(!isset($connection)) 
	        {
	            // Load configuration as an array. Use the actual location of your configuration file
	            include_once('Ini.class.php');
	            if(substr_count($_SERVER['PHP_SELF'], '/')>2)
    				$config = new IniParser( '../config.ini' );
    			else
    				$config = new IniParser( 'config.ini' );
	            $connection = mysqli_connect($config->getValue('server'),$config->getValue('usuario'),$GLOBALS['id_cliente'],$config->getValue('banco'));
	            //mysqli_query($connection,"SET NAMES 'utf8'");
				//mysqli_query($connection,"SET character_set_connection=utf8");
				//mysqli_query($connection,"SET character_set_client=utf8");
				//mysqli_query($connection,"SET character_set_results=utf8");
				//mysqli_query($connection,"SET character_encoding_server=utf8mb4 ");
	        }
	        // If connection was not successful, handle the error
	        if($connection === false) {
	            // Handle error - notify administrator, log to a file, show an error screen, etc.
	            return mysqli_connect_error();
	        }
	        //mysqli_close($connection);
	        return $connection;
    	}


		public function inserir($formulario,$tabela) 
		{
			unset($formulario['id']);
			$connection = $this->db_connect();
			//print_r($formulario);
			$campo="";	$dado="";	$alterar="";
				foreach($formulario as $cod => $valor){
					$x = substr($cod, 0,2);
					//$valor = utf8_decode($valor);
					if($x <> "x_") {
						if(false===strrpos($campo,$cod))
						{
							$campo.="$cod,"; 
						}
						$dado.="'$valor',";
					}
				}
				$a = strlen($campo);	 $campos = substr($campo, 0,$a-1);
				$b = strlen($dado); 	 $dados = substr($dado, 0,$b-1);
				//echo $campo;
				//echo $dado;
				$query = mysqli_query($connection,"INSERT INTO $tabela ($campos) VALUES ($dados)") or die (mysqli_error($connection));
				//echo $query;
				if($query) 
				{ 
					return true;
				}	
				else
				{
					return false;
				}
		}

		public function alterar($campo,$valor,$tabela,$campoId,$id) 
		{
			$connection = $this->db_connect();
			//$t="UPDATE $tabela set $campo=$valor where $campoId='$id'";
			$query = mysqli_query($connection,"UPDATE $tabela set $campo=$valor where $campoId='$id'") or die (mysqli_error($connection));
			//echo $query;
			if($query) 
			{ 
				return true;
			}
			else
				return false;
		}

		public  function acaoCrud($formulario,$tabela,$acao,$campoId,$id) 
		{
			$connection = $this->db_connect();
			$campo="";	$dado="";	$alterar="";
				foreach($formulario as $cod => $valor){
					$x = substr($cod, 0,2);
					$valor = htmlentities($valor);
					if($x <> "x_") {

						if($cod=='senha')
						{
							$valor=md5($valor);
						}

						$campo.="$cod,"; 
						$dado.="'$valor',";
						$alterar.="$cod='$valor',"; 
					}
				}
				$a = strlen($campo);	 $campos = substr($campo, 0,$a-1);
				$b = strlen($dado); 	 $dados = substr($dado, 0,$b-1);
				$c = strlen($alterar);   $alterar = substr($alterar, 0,$c-1);
					switch($acao) {
						case 'insert': 
							$query = mysqli_query($connection,"INSERT INTO $tabela ($campos) VALUES ($dados)") or die(mysqli_error($connection));
							if($query) 
							{ 
								return true;
							}	
							else
							{	
								return false;
							}
							break;
						case 'update':
							//print_r($alterar);
							$query = mysqli_query($connection,"UPDATE $tabela set $alterar where $campoId='$id'") or die (mysqli_error($connection));
							//print_r($query);
							if($query) 
							{ 
								return true;
							}	
							else
							{	
								return false;
							}
					}
		}
		
		public  function deletar($tab,$campo,$valorCampo) 
		{
			$connection = $this->db_connect();
			if(!empty($tab) && !empty($campo) && !empty($valorCampo)) 
			{
				$sql="DELETE FROM $tab WHERE $campo='$valorCampo'";
				$query = mysqli_query($connection,$sql) or die (mysqli_error());
				if($query)
					return true;
				else	
					return false;
			}
		}

		public function listar($tab,$orderby)
		{
			$connection = $this->db_connect();
			if($tab=='mesa')
				$sql="SELECT * FROM $tab ORDER BY descricao * 1";
			else
				$sql="SELECT * FROM $tab ORDER BY $orderby";
			$this->resultado=mysqli_query($connection,$sql);
		}

		//retorna o mysqliquery
		public function listar2($tab,$orderby)
		{
			$connection = $this->db_connect();
			$sql="SELECT * FROM $tab ORDER BY $orderby";
			return mysqli_query($connection,$sql);
		}
		
		public function pesquisaTabela($tab,$campos)//EDITADO
		{
			$connection = $this->db_connect();
			$sql="SELECT * FROM $tab WHERE "; 
			foreach ($campos as $campo => $valor) {
				$valor = utf8_decode($valor);
				if($campo=="senha"){
					$sql.="$campo='".md5($valor)."' AND ";
				}
				else{
					$sql.="$campo='$valor' AND ";
				}
			}
			$sql=substr($sql, 0,$sql-4);
			//echo $sql;
			$this->resultado=mysqli_query($connection,$sql);
		}

		public function pesquisarTabela($tab,$campo,$valorCampo)
		{
			$connection = $this->db_connect();
			$sql="SELECT * FROM $tab WHERE $campo='$valorCampo'";
			$this->resultado=mysqli_query($connection,$sql);
		}

		//retorna o mysqliquery
		public function pesquisarTabela2($tab,$campo,$valorCampo)
		{
			$connection = $this->db_connect();
			$sql="SELECT * FROM $tab WHERE $campo='$valorCampo'";
			return mysqli_query($connection,$sql);
		}
		
		public function ultimoAcesso($tab,$campo,$valorCampo)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT MAX(idAcessoPessoa) FROM $tab WHERE $campo='$valorCampo'");
			$row = mysqli_fetch_array($res);
			return $row[0];
		}

		public function verificaValidadeLicenca()
		{
			include_once 'mac.php';
			$connection = $this->db_connect();
			$res=mysqli_query($connection,"SELECT * FROM licenca");
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
					$pegamac = new Mac;
					$pcmac= $pegamac->MacId();
					if(strcmp($mac, $pcmac)==0)
					{
						if(strtotime(date("d-m-Y",$data_now))<=strtotime(date("d-m-Y",$data)))
							return true;
						else
							return false;	
					}
				}
			}
		}

		public function verificaLicenca($pcmac)
		{
			$connection = $this->db_connect();
			$res=mysqli_query($connection,"SELECT * FROM licenca");
			$retorno=false;
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
					if(strcmp($mac, $pcmac)==0)
					{
						$retorno=true;
					}
				}
			}
			return $retorno;
		}

		public function verificaValidadeLicencaDias()
		{
			include_once 'mac.php';
			$connection = $this->db_connect();
			$res=mysqli_query($connection,"SELECT * FROM licenca");
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
					$pegamac = new Mac;
					$pcmac= $pegamac->MacId();
					if(strcmp($mac, $pcmac)==0)
					{
						$data1 = new DateTime( date("Y-m-d",$data_now));
						$data2 = new DateTime(  date("Y-m-d",$data));
						$intervalo = $data1->diff( $data2 );
						return $intervalo->days;
					}
				}
			}
		}
		
		//pode retornar um array
		public function pesquisarCampo($tab,$campo_pesquisa,$id)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT $campo_pesquisa FROM $tab WHERE id=$id");
			return $res;
		}

		public  function pesquisarNomeDaTele($id)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT c.nome
							from cliente c inner join
							tele t on c.id=t.cliente_id
							where t.id=$id");
			$row=mysqli_fetch_array($res);
			return $row[0];
		}

		public function pegaUltimoIdInserido()
		{
			$connection = $this->db_connect();
			return mysqli_insert_id($connection);
		}

		public function inserir_retornando_id($formulario,$tabela) 
		{
			$connection = $this->db_connect();
			//print_r($formulario);
			$campo="";	$dado="";	$alterar="";
				foreach($formulario as $cod => $valor){
					$x = substr($cod, 0,2);
					$valor = utf8_decode($valor);
					if($x <> "x_") {
						if(false===strrpos($campo,$cod))
						{
							$campo.="$cod,"; 
						}
						$dado.="'$valor',";
					}
				}
				$a = strlen($campo);	 $campos = substr($campo, 0,$a-1);
				$b = strlen($dado); 	 $dados = substr($dado, 0,$b-1);
				//echo $campo;
				//echo $dado;
				$query = mysqli_query($connection,"INSERT INTO $tabela ($campos) VALUES ($dados)") or die(mysqli_error($connection));
				//echo $query;
				if($query) 
				{ 
					return mysqli_insert_id($connection);
				}	
				else
				{
					return false;
				}
		}

		public  function pesquisaCampo($tab,$campo,$id)
		{
			$connection = $this->db_connect();			
			$res = mysqli_query($connection,"SELECT $campo FROM $tab WHERE id=$id");
			if($res)
			{
				$row = mysqli_fetch_array($res);
				return $row[0];
			}
			else
				return '';
			
		}

		public function listarItensCozinha()
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.id, (pic.quantidade - pic.quantidade_entregue) as quantidade, ic.descricao, m.descricao as mesa,pic.hora,pic.obs
						FROM item_cardapio ic INNER JOIN
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id INNER JOIN
						pedido p ON pic.pedido_id=p.id LEFT JOIN
						mesa m ON m.id=p.mesa_id
						WHERE pic.situacao=0 AND ic.categoria=1 AND p.situacao=0
						ORDER BY pic.hora";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarDividas()
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT d.id,d.descricao,credor_id,nome,data_vencimento,data_pagamento,situacao,valor
							FROM divida d inner join credor c
							ON d.credor_id=c.id
							where situacao=0 
							ORDER BY nome";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		//retorna o mysqliquery
		public function listarDivida($id)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT d.id,credor_id,d.descricao,nome,data_vencimento,data_pagamento,situacao,valor
							FROM divida d inner join credor c
							ON d.credor_id=c.id
							WHERE d.id=$id 
							ORDER BY nome";
			return mysqli_query($connection,$sql_query);
		}

		public function listarItensTotaisCozinha()
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT sum(pic.quantidade - pic.quantidade_entregue) as soma,ic.descricao
						FROM item_cardapio ic inner join
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id inner join
						pedido p on p.id=pic.pedido_id
						WHERE pic.situacao=0 AND ic.categoria=1
						and p.situacao=0
						group by ic.id";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensAuxiliar($categoria)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.id, pic.quantidade, ic.descricao, m.descricao as mesa,pic.hora,pic.obs,
						p.nome, pic.quantidade_entregue,ic.valor,c.nome as cliente
						FROM item_cardapio ic INNER JOIN
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id INNER JOIN
						pedido p ON pic.pedido_id=p.id LEFT JOIN
						mesa m ON m.id=p.mesa_id left join
						cliente c on p.cliente_id=c.id
						WHERE pic.situacao=0 AND ic.categoria=$categoria AND p.situacao=0
						ORDER BY pic.hora";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensPedidoCaixa($pedido)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.id, SUM(pic.quantidade) as quantidade, ic.descricao, m.descricao as mesa,pic.hora,
						p.nome, pic.quantidade_paga,ic.valor
						FROM item_cardapio ic INNER JOIN
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id INNER JOIN
						pedido p ON pic.pedido_id=p.id LEFT JOIN
						mesa m ON m.id=p.mesa_id
						WHERE p.id=$pedido AND p.situacao=0
						GROUP BY ic.descricao 
						ORDER BY pic.hora";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensPedidoCaixaNovo($pedido)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT ic.id, SUM(pic.quantidade) as quantidade, ic.descricao, m.descricao as mesa,pic.hora,
						p.nome, SUM(pic.quantidade_paga) as quantidade_paga,ic.valor,p.data_pedido as data,
                        u.login as garcom,p.obs
						FROM item_cardapio ic INNER JOIN
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id INNER JOIN
						pedido p ON pic.pedido_id=p.id LEFT JOIN
						mesa m ON m.id=p.mesa_id INNER JOIN
                        usuario u ON p.usuario_id=u.id
						WHERE p.id=$pedido AND p.situacao=0
						GROUP BY ic.descricao 
						ORDER BY pic.hora";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensPedidoCupomEntregar($pedido,$categoria)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.id as pic,ic.id, SUM(pic.quantidade) as quantidade, ic.descricao, m.descricao as mesa,pic.hora,
						p.nome,c.nome as cliente, SUM(pic.quantidade_paga) as quantidade_paga,ic.valor,p.data_pedido as data,
                        u.login as garcom,p.obs
						FROM item_cardapio ic INNER JOIN
						pedido_has_item_cardapio pic ON
						ic.id=pic.item_cardapio_id INNER JOIN
						pedido p ON pic.pedido_id=p.id LEFT JOIN
						mesa m ON m.id=p.mesa_id INNER JOIN
                        usuario u ON p.usuario_id=u.id left join
                        cliente c on p.cliente_id=c.id
						WHERE p.id=$pedido AND p.situacao=0
                        and ic.categoria=$categoria
                        and pic.situacao=0
						GROUP BY ic.descricao 
						ORDER BY pic.hora";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarPedidosCaixa($campo,$valorCampo,$orderby)
		{
			$connection = $this->db_connect();
			$sql="SELECT p.id,c.nome as cliente,p.situacao,p.valor,p.data_pedido,p.porcentagem_garcom,m.descricao,p.obs
				FROM pedido p left JOIN mesa m
				on p.mesa_id=m.id left join cliente c
				on p.cliente_id=c.id
				WHERE $campo='$valorCampo' ORDER BY $orderby";
			$this->resultado=mysqli_query($connection,$sql);
		}

		public function pesquisarQuantidadeItem($id)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT pe.formaQuantidade,ic.formaVenda,ic.quantidadeVenda,pic.quantidade,
								pe.id,pe.quantidade as quantEstoque 
								from item_cardapio ic inner join produto_estoque pe
								on ic.produto_estoque_id=pe.id inner join pedido_has_item_cardapio pic
								on pic.item_cardapio_id=ic.id
								where pic.id=$id");
			$row = mysqli_fetch_array($res);
			return $row;
		}

		public function pesquisarQuantidadeEntregarTele($idtele)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT pe.id,tic.quantidade,ic.formaVenda,ic.quantidadeVenda,pe.formaQuantidade
								from tele_has_item_cardapio tic inner join
								item_cardapio ic on tic.item_cardapio_id=ic.id inner join
								produto_estoque pe on ic.produto_estoque_id=pe.id
								where tic.tele_id=$idtele");
			return $res;
		}

		public function pesquisarValoresTotaisPedido($idpedido)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT p.valor ,sum(pic.quantidade_paga*ic.valor) as valorpago, 
											(p.valor-sum(pic.quantidade_paga*ic.valor)) as valorapagar,
											u.login as garcom
											FROM pedido p inner join 
											pedido_has_item_cardapio pic on
											p.id=pic.pedido_id inner join 
											item_cardapio ic on
											ic.id=pic.item_cardapio_id inner join
											usuario u on p.usuario_id=u.id
											WHERE p.id=$idpedido AND p.situacao=0");
			$row = mysqli_fetch_array($res);
			return $row;
		}

		public function pesquisarDetalhesPedido($idpedido)
		{
			$connection = $this->db_connect();
			$res = mysqli_query($connection,"SELECT p.id ,c.nome,u.login as garcom,m.descricao,p.obs
												from pedido p inner join 
												usuario u on
												p.usuario_id=u.id left join 
												mesa m on
												p.mesa_id=m.id left join
												cliente c on
												p.cliente_id=c.id
												where p.id=$idpedido and p.situacao=0");
			$row = mysqli_fetch_array($res);
			return $row;
		}

		public function count($tabela)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT COUNT(id) FROM $tabela";
			$row = mysqli_query($connection,$sql_query);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		public  function count2($tabela,$campos)
		{
			$connection = $this->db_connect();
			$sql="SELECT COUNT(id) FROM $tabela WHERE "; 
			foreach ($campos as $campo => $valor) {
				$valor = utf8_decode($valor);
				$sql.="$campo='$valor' AND ";
			}
			$sql=substr($sql, 0,$sql-4);
			$row = mysqli_query($connection,$sql);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		public  function countFecharPedido($idpedido)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT COUNT(pedido_id) FROM pedido_has_item_cardapio
							where quantidade<>quantidade_paga
							and pedido_id=$idpedido";
			$row = mysqli_query($connection,$sql_query);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		public  function countMesasOcupadas()
		{
			$connection = $this->db_connect();
			$sql="select count(id)
					from mesa
					where id in
					(select mesa_id from pedido
					where situacao=0)";
			$row = mysqli_query($connection,$sql);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		public  function countPedidosEsperandoItens()
		{
			$connection = $this->db_connect();
			$sql="SELECT count(id)
					from pedido
					where id in
					(select pedido_id from pedido_has_item_cardapio
					where situacao=0) and situacao=0";
			$row = mysqli_query($connection,$sql);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		public function listarPedidosGarcom($idmesa)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT p.id,p.mesa_id,p.usuario_id,p.valor,p.data_pedido,c.nome,p.obs,u.login 
						FROM pedido p left join cliente c on p.cliente_id=c.id 
						left join usuario u on p.usuario_id=u.id
						WHERE mesa_id=".$idmesa." AND
							situacao='false'";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensPedidoGarcom($idpedido)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.id,ic.descricao,pic.quantidade,ic.valor,pic.situacao
						FROM item_cardapio ic INNER JOIN pedido_has_item_cardapio pic
						ON ic.id=pic.item_cardapio_id
						WHERE pic.pedido_id=".$idpedido;
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensTele($idtele,$categoria)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT tic.id,ic.descricao,tic.quantidade,ic.valor
						FROM item_cardapio ic INNER JOIN tele_has_item_cardapio tic
						ON ic.id=tic.item_cardapio_id
						WHERE tic.tele_id=".$idtele." and
							ic.categoria=$categoria";
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensTeleTodos($idtele)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT tic.id,ic.descricao,tic.quantidade,ic.valor,tic.obs 
						FROM item_cardapio ic INNER JOIN tele_has_item_cardapio tic
						ON ic.id=tic.item_cardapio_id
						WHERE tic.tele_id=".$idtele;
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarTeles($situacao)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT t.id,c.nome,t.cliente_id,t.valor,t.data_tele,t.taxa 
							FROM tele t 
							INNER JOIN cliente c on t.cliente_id=c.id
							WHERE t.situacao=".$situacao;
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarTele($id)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT t.id,c.nome,c.endereco,c.bairro,c.cidade,c.telefone,t.valor,t.data_tele,t.taxa FROM tele t 
							INNER JOIN cliente c on t.cliente_id=c.id
							WHERE t.id=".$id;
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function listarItensPedido($idpedido)
		{
			$connection = $this->db_connect();
			$sql_query = "SELECT pic.quantidade,ic.valor
						FROM item_cardapio ic INNER JOIN pedido_has_item_cardapio pic
						ON ic.id=pic.item_cardapio_id
						WHERE pic.pedido_id=".$idpedido;
			$this->resultado = mysqli_query($connection,$sql_query);
		}

		public function getStatusMesa($idmesa)
		{
			$connection = $this->db_connect();
			$sql_query = "select count(id) from pedido where mesa_id=$idmesa and situacao=0";
			$row = mysqli_query($connection,$sql_query);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		/*CONSULTAS PARA OS RELATORIOS*/

		//retorna o mysqarray
		public function totalPedidosPorDia($data)
		{
			$connection = $this->db_connect();
			$sql="SELECT count(id)
					from pedido
					where data_pedido = '$data'";
			$row = mysqli_query($connection,$sql);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		//retorna o mysqliarray
		public function totalPedidosPorPeriodo($dataInicio,$dataFim)
		{
			$connection = $this->db_connect();
			$sql="SELECT count(id)
					from pedido
					where data_pedido BETWEEN '$dataInicio' AND '$dataFim'";
			$row = mysqli_query($connection,$sql);
			$value = mysqli_fetch_array($row);
			return $value[0];
		}

		//retorna o mysqliquery
		public function quantidadeVendidaPorCategoria()
		{
			$connection = $this->db_connect();
			$sql="SELECT count(pic.id) as count,categoria
					from pedido_has_item_cardapio pic
					inner join item_cardapio ic
					on pic.item_cardapio_id=ic.id
					group by categoria";
			$row = mysqli_query($connection,$sql);
			return $row;
		}

		public function relatorioVendasPorData($data_inicio,$data_final,$dinheiro,$credito,$debito)
		{
			$connection = $this->db_connect();
			$sql="SELECT p.data_pedido,c.nome,p.valor,p.porcentagem_garcom,
						p.modo_pagamento,u.login,p.obs
						from pedido p inner join usuario u on p.usuario_id=u.id
						left join cliente c on p.cliente_id=c.id
						where p.data_pedido BETWEEN '$data_inicio' AND '$data_final'
						and p.situacao=1";
			if($dinheiro=="true")
				$sql=$sql." and ( modo_pagamento like '0'"; 
			if($credito=='true')
			{
				if(strrpos($sql,"and ( modo_pagamento"))
					$sql=$sql." or";
				else
					$sql=$sql." and (";
				$sql=$sql." modo_pagamento like '1'"; 
			}
			if($debito=='true')
			{
				if(strrpos($sql,"and ( modo_pagamento"))
					$sql=$sql." or";
				else
					$sql=$sql." and (";
				$sql=$sql." modo_pagamento like '2'"; 
			}
			if(($dinheiro=='true')||($credito=='true')||($debito=='true'))
				$sql=$sql.")";
			$sql." order by data_pedido";
			//echo $sql;
			$this->resultado = mysqli_query($connection,$sql);
		}

		public function relatorioTelePorData($data_inicio,$data_final)
		{
			$connection = $this->db_connect();
			$sql="SELECT t.data_tele,c.nome,t.valor,t.taxa,u.login
						from tele t inner join cliente c  
						on t.cliente_id=c.id 
						left join usuario u
						on t.usuario_id=u.id
						where t.data_tele BETWEEN '$data_inicio' AND '$data_final'
						and t.situacao=1";
			$sql." order by data_tele";
			//echo $sql;
			$this->resultado = mysqli_query($connection,$sql);
		}

		public function relatorioDividasPorData($data_inicio,$data_final,$situacao,$credor)
		{
			$connection = $this->db_connect();
			$sql="SELECT d.descricao,d.data_vencimento,d.data_pagamento,c.nome,d.valor,d.situacao
						from divida d inner join credor c 
						on c.id=d.credor_id 
						where d.data_vencimento BETWEEN '$data_inicio' AND '$data_final'";
			if($situacao=="true")
				$sql=$sql." and d.situacao=1";
			else
				$sql=$sql." and d.situacao=0";
			$sql." order by data_vencimento";
			//echo $sql;
			$this->resultado = mysqli_query($connection,$sql);
		}

		public function entregaItensPorCategoria($idpedido,$categoria) 
		{
			$connection = $this->db_connect();
			//$t="UPDATE $tabela set $campo=$valor where $campoId='$id'";
			$query = mysqli_query($connection,"UPDATE pedido_has_item_cardapio as ph
							inner join item_cardapio ic
							on ph.item_cardapio_id=ic.id
							set quantidade_entregue=quantidade,situacao=1
							where ph.pedido_id=$idpedido
							and ic.categoria=$categoria") or die (mysqli_error($connection));
			//echo $query;
			if($query) 
			{ 
				return true;
			}
			else
				return false;
		}

		public function getconsulta()
		{
			return $this->resultado;
		}

}
	
?>
	
	
		