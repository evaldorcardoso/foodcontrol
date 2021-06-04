<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
    <title>FoodControl - Cozinha</title>
    <style type="text/css">
        body{
        background-color: #690202;
      }

        .pricing_header { background: none repeat scroll 0% 0% rgb(255, 255, 255); border-radius: 5px 5px 0px 0px; transition: background 0.4s ease-out 0s; }
        .pricing_header h3 { text-align:center; line-height: 10px; padding: 15px 0px; margin: 0px; font-family: "Quicksand", sans-serif; font-weight: 400; color: #000; }
        .list-group-item:first-child { border-top-right-radius: 0px; border-top-left-radius: 0px; }
        .off { text-decoration: line-through; color: rgb(86,86,86); }
        .space {height: 2px; background-color: #75b1ae;}
    </style>
    
    <script type="text/javascript">
        //atualizar pagina em determinado tempo
        setInterval(function(){
            window.location.reload(1);
        }, 20000);

        function pronto(id)
        {
            var queryString="id="+id+"&situacao=1";

            buscaDados("statusPronto"+id,queryString,"../get/getItemCardapio.php?action=pronto","Erro","../");
        }    

        function removeDaLista(id)
        {
            $("#item-"+id).remove();
        }
    </script>
</head>
<body>
<div class="container">
	<center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Modo Cozinha</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>
    
    <div class="row">
        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-9">
            <table id="tabelaItens" class="table table-hover" style="background-color:#fff">
                <thead>
                    <tr>
                        <th>Quantidade:</th>
                        <th>Produto:</th>
                        <!--<th class="text-center">Ações:</th>-->
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $cClass->listarItensCozinha();
                    if($cClass->getConsulta()==false)
                    {
                        ?>
                        <tr>
                            <strong>Nenhum Item para fazer...</strong>
                        </tr>
                        <?php
                    }
                    else
                    {
                        while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                        { ?>
                            <tr id="item-<?php echo $array_['id'];?>">
                                <td class="col-sm-1 col-md-1">
                                    <strong><?php echo $array_['quantidade'];?> x</strong>
                                </td>
                                <td class="col-sm-8 col-md-6">
                                    <div class="media">
                                        <div class="media-body">
                                            <h4 style="color:#1504FB" class="media-heading"><?php echo $array_['descricao'];?></h4>
                                            <span><?php echo $array_['obs'];?></span>
                                        </div>
                                    </div>
                                </td>
                                <!--<td class="col-sm-1 col-md-1">
                                    <button type="button" class="btn btn-primary" onclick="pronto('<?php echo $array_['id'];?>')">
                                        <span class="glyphicon glyphicon-upload"></span> Pronto
                                    </button>
                                    <div id="statusPronto<?php echo $array_['id'];?>"></div>
                                </td>-->
                            </tr>    
                    <?php }
                    } ?>                    
                </tbody>
            </table>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-3">
            <div class="pricing_header">
                <h3>Total</h3>
                <div class="space"></div>
            </div>
            <ul class="list-group">
                <?php
                $cClass->listarItensTotaisCozinha();
                if($cClass->getConsulta()==false)
                { }
                else
                {
                    while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                    { ?>
                        <li class="list-group-item"><span class="glyphicon glyphicon-cutlery"></span> <?php echo $array_['descricao'];?> <span style="font-size: 90%;" class="pull-right label label-danger"><?php echo $array_[0];?></span></li>
              <?php }
                } ?>

            </ul>
        </div>
    </div>
</div>
</body>