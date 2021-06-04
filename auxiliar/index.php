<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/waitingfor.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
    <title>FoodControl - Auxiliar</title>
    <style type="text/css">
    	body {
    padding-top: 10px; 
    background-color: #690202;
}
    </style>
    
    <script type="text/javascript">
    	$(document).ready(function() {
            $('[id^=detail-]').hide();
            $('.toggle').click(function() {
                $input = $( this );
                $target = $('#'+$input.attr('data-toggle'));
                $target.slideToggle();
            });
        });

        function entregue(id,quantEntregue,quant,categoria)
        {
            var quantAtual=document.getElementById("quant-"+id).value;
            if((quantAtual<=(quant-quantEntregue))&&(quantAtual>0))
            {
                var quantidade_entregue=parseInt(quantEntregue)+parseInt(document.getElementById("quant-"+id).value);
                var queryString="id="+id+"&quantidade_entregue="+quantidade_entregue;
                if(categoria=='2')
                    queryString+="&categoria=2"+"&quantEntregue="+quantAtual;
                //alert(queryString);
                buscaDados("statusEntregue"+id,queryString,"../get/getItemCardapio.php?action=entregue","Erro","../");
            }
            else
            {
                alert("Quantidade inválida");
            }
        }

        function removeDaLista(id)
        {
            //alert("vou remover");
            $("#item-"+id).remove();
        }

    </script>

</head>
<body>
    <?php
    include_once('../classes/Ini.class.php');
    $config = new IniParser( '../config.ini' );
    ?>
<div class="container">
	<center><h3 style="color:#fff">Auxiliar:</h3><hr></center>
    <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Modo Auxiliar</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>
	
    <ul class="list-group">
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                    <div class="col-xs-10">
                        <h4><span class="glyphicon glyphicon-cutlery"></span> Comida</h4>
                    </div>
                    <div class="col-xs-2"><i class="glyphicon glyphicon-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-1">
                    <hr></hr>
                    <!--<div class="container">-->
                        <div id="row-comida" class="row">
                            <table id="tabelaItensComida" class="table table-hover" style="background-color:#fff">
                            <thead>
                                <tr>
                                    <th>Quant.:</th>
                                    <th>Produto:</th>
                                    <th>Hora:</th>
                                    <?php if($config->getValue('modo_venda')=='mesa')
                                    { echo '<th>Mesa:</th>';} ?>
                                    <th>Cliente:</th>
                                    <th>Quant. à entregar:</th>
                                    <th class="text-center">Ações:</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $cClass->listarItensAuxiliar(1);
                                if($cClass->getConsulta()==false)
                                { ?>
                                <tr>
                                    <strong>Nenhum Item para entregar...</strong>
                                </tr>
                          <?php }
                                else
                                {
                                    while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                                    { ?>
                                        <tr id="item-<?php echo $array_['id'];?>">
                                            <td class="col-sm-1 col-md-1">
                                                <strong><?php echo ($array_['quantidade']-$array_['quantidade_entregue']);?> x</strong>
                                            </td>
                                            <td class="col-sm-6 col-md-6">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h4 style="color:#1504FB" class="media-heading"><?php echo $array_['descricao'];?></h4>
                                                        <span><?php echo $array_['obs'];?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-sm-2 col-md-2">
                                                <strong><?php 
                                                    $date=date_create($array_['hora']);
                                                    echo date_format($date,'G:ia');
                                              ?></strong>
                                            </td>
                                            <?php if($config->getValue('modo_venda')=='mesa')
                                            { echo '<td class="col-sm-1 col-md-1">
                                                <strong>'.$array_['mesa'].'</strong>
                                            </td>';} ?>
                                            <td class="col-sm-2 col-md-2">
                                                <strong><?php echo $array_['nome']; if($array_['nome']=='') echo $array_['cliente'];?></strong>
                                            </td>
                                            <td class="col-xs-1 col-sm-1 col-md-1">
                                                <input id="quant-<?php echo $array_['id'];?>" type="number" class="form-control text-left" value="<?php echo ($array_['quantidade']-$array_['quantidade_entregue']);?>"> 
                                            </td>
                                            <td class="col-sm-2 col-md-2">
                                                <button type="button" class="btn btn-primary" onclick="entregue('<?php echo $array_['id'];?>','<?php echo $array_['quantidade_entregue'];?>','<?php echo $array_['quantidade'];?>','1')">
                                                    <span class="glyphicon glyphicon-upload"></span> Entregar
                                                </button>
                                                <div id="statusEntregue<?php echo $array_['id'];?>"></div>
                                            </td>
                                        </tr>    
                    <?php }
                    } ?>                    
                </tbody>
            </table>
                        </div>
                    <!--</div><!-- /container-->
                </div>
            </li>
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                    <div class="col-xs-10">
                       <h4><span class="glyphicon glyphicon-glass"></span> Bebida</h4>
                    </div>
                    <div class="col-xs-2"><i class="glyphicon glyphicon-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-2">
                    <hr></hr>
                        <div id="row-bebida" class="row">
                            <table id="tabelaItensBebida" class="table table-hover" style="background-color:#fff">
                            <thead>
                                <tr>
                                    <th>Quantidade:</th>
                                    <th>Produto:</th>
                                    <th>Hora:</th>
                                    <?php if($config->getValue('modo_venda')=='mesa')
                                    { echo '<th>Mesa:</th>'; } ?>
                                    <th>Cliente:</th>
                                    <th>Quant. à entregar:</th>
                                    <th class="text-center">Ações:</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $cClass->listarItensAuxiliar(2);
                                if($cClass->getConsulta()==false)
                                { ?>
                                <tr>
                                    <strong>Nenhum Item para entregar...</strong>
                                </tr>
                          <?php }
                                else
                                {
                                    while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                                    { ?>
                                        <tr id="item-<?php echo $array_['id'];?>">
                                            <td class="col-sm-1 col-md-1">
                                                <strong><?php echo ($array_['quantidade']-$array_['quantidade_entregue']);?> x</strong>
                                            </td>
                                            <td class="col-sm-8 col-md-6">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h4 style="color:#1504FB" class="media-heading"><?php echo $array_['descricao'];?></h4>
                                                        <span><?php echo $array_['obs'];?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-sm-2 col-md-2">
                                                <strong><?php 
                                                    $date=date_create($array_['hora']);
                                                    echo date_format($date,'G:ia');
                                              ?></strong>
                                            </td>
                                            <?php if($config->getValue('modo_venda')=='mesa')
                                            { echo '<td class="col-sm-1 col-md-1">
                                                <strong>'.$array_['mesa'].'</strong>
                                            </td>';} ?>
                                            <td class="col-sm-2 col-md-2">
                                                <strong><?php echo $array_['nome']; if($array_['nome']=='') echo $array_['cliente'];?></strong>
                                            </td>
                                            <td class="col-xs-1 col-sm-1 col-md-1">
                                                <input id="quant-<?php echo $array_['id'];?>" type="number" class="form-control text-left" value="<?php echo ($array_['quantidade']-$array_['quantidade_entregue']);?>"> 
                                            </td>
                                            <td class="col-sm-2 col-md-2">
                                                <button type="button" class="btn btn-primary" onclick="entregue('<?php echo $array_['id'];?>','<?php echo $array_['quantidade_entregue'];?>','<?php echo $array_['quantidade'];?>','2')">
                                                    <span class="glyphicon glyphicon-upload"></span> Entregar
                                                </button>
                                                <div id="statusEntregue<?php echo $array_['id'];?>"></div>
                                            </td>
                                        </tr>    
                    <?php }
                    } ?>                    
                </tbody>
            </table>
                        </div>
                </div>
            </li>
        </ul>
</div>
</body>