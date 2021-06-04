<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<head>
    <script type="text/javascript">
        window.print();
    </script>
</head>
<body>
<?php
    if((isset($_GET['data_inicio']))&&(isset($_GET['data_final'])))
    {
      ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
                <?php
                $datei=date_create($_GET['data_inicio']);
                $datef=date_create($_GET['data_final']);
                ?>
    			<h2>Relatório Financeiro</h2><h3 class="pull-right">De <?php echo date_format($datei, 'd/m/Y');?> à <?php echo date_format($datef, 'd/m/Y');?></h3>
    		</div>
            <br><br>
    		<hr>
            <table class="col-md-12 table-bordered table-condensed" style="margin-bottom:10%">
            <?php
            //BUSCA OS DADOS NO BANCO DE DADOS
            include_once "../classes/crudClass.php";
            $cClass = new crudClass();
            $cClass->relatorioVendasPorData($_GET['data_inicio'],$_GET['data_final'],$_GET['dinheiro'],$_GET['credito'],$_GET['debito']);
            if(0<>mysqli_num_rows($cClass->getconsulta()))
            {
             echo '<thead>
                        <tr>
                            <th>Data</th>';
                            if($_GET['cliente']=='true')
                                echo '<th>Cliente</th>';
                            if(($_GET['dinheiro']=='true')||($_GET['credito']=='true')||($_GET['debito']=='true'))
                                echo '<th>Modo de Pagamento</th>';
                            if($_GET['pg']=='true')
                            {
                                echo '<th>Garçom</th>';
                                echo '<th>Garçom (R$)</th>';
                            }
                            if($_GET['obs']=='true')
                                echo '<th>Observação</th>';
                            echo '<th>Valor (R$)</th>
                        </tr>
                    </thead>
                        <tbody>';
                $contTotal=0;
                while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                {
                    $date=date_create($array_['data_pedido']);
                    echo '<tr>
                        <td>'.date_format($date, 'd/m/Y').'</td>';
                        if($_GET['cliente']=='true')
                            echo '<td>'.$array_['nome'].'</td>';
                        if(($_GET['dinheiro']=='true')||($_GET['credito']=='true')||($_GET['debito']=='true'))
                        {
                            $modo_pagamento=$array_['modo_pagamento'];
                            if($modo_pagamento=='0')
                                $modo_pagamento='Dinheiro';
                            if($modo_pagamento=='1')
                                $modo_pagamento='Crédito';
                            if($modo_pagamento=='2')
                                $modo_pagamento='Débito';
                            echo '<td>'.$modo_pagamento.'</td>';
                        }
                        if($_GET['pg']=='true')
                        {
                            echo '<td>'.$array_['login'].'</td>';
                            echo '<td>'.$array_['porcentagem_garcom'].'</td>';
                        }
                        if($_GET['obs']=='true')
                            echo '<td>'.$array_['obs'].'</td>';
                        echo '<td>'.$array_['valor'].'</td>
                        </tr>';
                    $contTotal+=$array_['valor'];
                }
                echo '</tbody>
                <h4>Total R$ '.number_format($contTotal,2,',','').'</h4>'; ?>
            </table>
            <hr>
            <center><h5>Relatório Financeiro criado pelo sistema FoodControl - <?php echo date("d/m/Y",time());?><h5></center>
            <br>
            </div>
    </div>
</div>
            <?php
            }
        }
?>
</body>