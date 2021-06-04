<?php
  session_start();
?>
<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="../css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="../js/bootstrap.js" type="text/javascript"></script>
<head>
    <script type="text/javascript">
        window.print();
    </script>
</head>


<body>
    <?php
    include_once "../classes/crudClass.php";
    $cClass = new crudClass();
    ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h3>Tele Entrega</h3><h4 class="pull-right"><?php $date=date_create($cClass->pesquisaCampo('tele','data_tele',$_GET["id"]));
                                                            echo date_format($date,'d-m-Y');?></h4>
    		</div>
            <br><br>
    		<hr>
            <?php
            if(isset($_GET['id']))
                $cClass->listarTele($_GET['id']);
            if(0<>mysqli_num_rows($cClass->getconsulta()))
            {
                //MONTA A ARRAY
                while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                {
                ?>
    		      <div class="row">
                    <h4>
    			<div class="col-xs-6">
    				<address>
    				<strong><u>Dados do Cliente</u>:</strong><br><br>
    					<b>Nome:</b> <?php echo $array_['nome'];?> <br>
    					<b>Endereço:</b> <?php echo $array_['endereco'];?> <br>
    					<b>Bairro:</b> <?php echo $array_['bairro'].' - ';?><?php echo $array_['cidade'];?><br>
                        <b>telefone:</b> <?php echo $array_['telefone'];?>
    				</address>
    			</div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong><u>Dados da Tele-Entrega</u>:</strong><br><br>
                        <b>Data:</b> <?php $date=date_create($array_['data_tele']);
                                                    echo date_format($date,'d-m-Y');?> <br>
                        <b>Taxa de Entrega:</b> <?php echo $array_['taxa'];?> <br>
                        <h3><b>Valor:</b> <?php echo 'R$ '.number_format($array_['valor']+$array_['taxa'],2);?> </h3><br>
                    </address>
                </div>
            </h4>
    		</div>

            <?php
            }//end while
            ?>
            <h4><strong><u>Itens da Tele</u>:</strong></h4><br>
            <?php
            $cClass->listarItensTeleTodos($_GET['id']);

            if(0<>mysqli_num_rows($cClass->getconsulta()))
            {
                //MONTA A ARRAY
                while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                {
                ?>
    		      <div class="row">
                    <h4>
    			         <div class="col-xs-6">
    				        <address>
    					       <?php echo $array_['quantidade'].' '.$array_['descricao'].'  - R$ '.$array_['valor'];?> <br>
                               <?php echo $array_['obs'];?>
    				        </address>
    			         </div>
    			    </h4>
    		      </div>
                <?php
                }//end while
            }//end if
        }//end if
        ?>
    	</div>
    </div>
    <hr><br>
    <center>___________________________________________<br>Recebido</center>
    <br><br><center>Sistema - <img src="../images/favicon.ico"/> FoodControl </center>
</div>
</body>s