<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="../css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="../js/bootstrap.js" type="text/javascript"></script>
<head>
    <script type="text/javascript">
        window.print();
    </script>
</head>


<?php

if(isset($_GET['idpedido']))
{
	
    //BUSCA OS DADOS NO BANCO DE DADOS
    include_once "../classes/crudClass.php";
    $cClass = new crudClass();
    $cClass->listarItensPedidoCaixaNovo($_GET['idpedido']);
    if(0<>mysqli_num_rows($cClass->getconsulta()))
    {
    	
		$total=0;
		$cont=0;
    	while($array_ = mysqli_fetch_array($cClass->getConsulta()))
        {
        	if($cont==0)
        	{
        		echo '<center><h5 style="font-size:70%">Sistema FoodControl</h5></center>';
				echo '<h5 style="font-size:60%">Cliente: '.$array_['nome'].'</h5>';
				echo '<h5 style="font-size:60%;text-align:right">Mesa: '.$array_['mesa'].'</h5>';
				echo '<center><br>Resumo do pedido:</center>';
        	}
        	echo '<br>'.$array_['quantidade'].' x  '.$array_['descricao'].'   = R$ '.$array_['valor'];
        	$total=$total+($array_['quantidade']*$array_['valor']);
        	$cont++;
        }
        echo '<br><br><p align="right">Total: R$ '.round($total,2).'</p>';
    }
}

?>