<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<script src="listgroup.min.js" type="text/javascript"></script>
<script src="../caixa/paneltablewithfilters.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<link href="../caixa/paneltablewithfilters.css" rel="stylesheet"><!-- style for table panel with filters -->
<?php include_once "../verificador/verificador.php"; ?>

<head>
    <title>FoodControl - Garçom</title>
    <style type="text/css">
    /*@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900|Oswald);*/
    @import url(../fonts/oswald.css?family=Source+Sans+Pro:400,900|Oswald);
    body{
        background-color: #690202;
        }
    .status {
        font-family: 'Source Sans Pro', sans-serif;
    }

    .panel-danger .panel-heading { background-color: red; }
    .panel-success .panel-heading { background-color: green; }

    .status .panel-title {
        font-family: 'Oswald', sans-serif;
        font-size: 72px;
        font-weight: bold;
        color: #fff;
        line-height: 45px;
        padding-top: 20px;
        letter-spacing: -0.8px;
    }
    </style>
    
    <script type="text/javascript">
        
        $(document).ready(function() 
        {
            //carregar o modal
            $('[data-toggle=modal]').click(function ()
            {
                //************************************************
                var data_id = '';
                if (typeof $(this).data('id') !== 'undefined') 
                {
                    data_id = $(this).data('id');
                }
                if(data_id=='')
                    data_id='0';
                var data_id_usuario = '';
                if (typeof $(this).data('id_usuario') !== 'undefined') 
                {
                    data_id_usuario = $(this).data('id_usuario');
                }
                //document.getElementsByClassName("list-group-item lgi").setAttribute("onclick", "selecionaCliente(this.id.substr(8),"+data_id+","+data_id_usuario+")");
                var list, index;
                list = document.getElementsByClassName("list-group-item lgi");
                for (index = 0; index < list.length; ++index) {
                    list[index].setAttribute("onclick", "selecionaCliente(this.id.substr(8),"+data_id +","+data_id_usuario+")");
                }
                document.getElementById('selecionaClienteButton').setAttribute("onclick", "selecionaCliente(document.getElementById('id_cliente').value,"+data_id+","+data_id_usuario+")");
                //************************************************
                /*var data_descricao = '';
                if (typeof $(this).data('descricao') !== 'undefined') 
                {
                    data_descricao = $(this).data('descricao');
                }
                titulo=document.getElementById('titulo');
                titulo.innerHTML='Mesa '+data_descricao;*/
                //************************************************
            });
        });

        function salvaPedido(cliente_id,mesa_id,usuario_id)
        {
            var situacao = 0;
            var valor=0;
            var currentdate = new Date(); 
            var data_pedido= currentdate.getFullYear() +"/"+ (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) +"/"+ ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate();   

            var queryString = "mesa_id="+mesa_id+"&situacao="+situacao;
            queryString+="&valor="+valor+"&data_pedido="+data_pedido+"&usuario_id="+usuario_id+"&cliente_id="+cliente_id;

            buscaDados("statusCadastro",queryString,"../get/getPedido.php?action=new","Não foi possível cadastrar",'../');
        }

        function selecionaCliente(cliente_id,mesa_id,usuario_id)
        {
          salvaPedido(cliente_id,mesa_id,usuario_id);
          //alert('cliente='+cliente_id+' mesa='+mesa_id+' usuario='+usuario_id);
        }

        function salvarCliente()
        {
          var nome=document.getElementById('nome_cliente').value;
          var endereco=document.getElementById('endereco_cliente').value;
          var bairro=document.getElementById('bairro_cliente').value;
          var cidade=document.getElementById('cidade_cliente').value;
          var telefone=document.getElementById('telefone_cliente').value;
          var queryString = "nome="+nome+"&endereco="+endereco;
          queryString+="&bairro="+bairro+"&cidade="+cidade+"&telefone="+telefone;
          var campos=['nome_cliente','endereco_cliente','telefone_cliente'];
          if(validaCampos(campos))
            buscaDados("statusCadastro",queryString,"../get/getCliente.php?action=novo_from_pedido","Não foi possível cadastrar",'');
        }

    </script>
</head>
<body>
<?php
    include_once '_modal_clientes.html';
    include_once('../classes/Ini.class.php');
    $config = new IniParser( '../config.ini' );
?>
<div class="container">
    <center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
    <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Modo Garçom</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
    </div><br>
    <div class="row">

    <!-- MODAL NOVO PEDIDO -->
    <div id="modalNomePedido" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="titulo"></h4>
                </div>
                <div class="modal-body">
                    <p>Informe um responsável pelo pedido</p>
                    <input id="nome_novo" type="text" class="form-control"  autocomplete="off" style="height:60px;font-size: 150%;" />
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-danger btn-lg" data-dismiss="modal">Cancelar</button>
                        <!--<button class="btn btn-warning btn-lg" >Reservar Mesa</button>-->
                        <button id="btn_criar_pedido" class="btn btn-primary btn-lg" >Criar Pedido</button>
                    </div>
                    <center><div id="statusCadastro"></div></center>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
    </div><!-- /.modal -->
    <?php 
            if($config->getValue('modo_venda')=='mesa')
            {
                $cClass -> listar('mesa','descricao');
                if(0==mysqli_num_rows($cClass->getconsulta()))
                {
                    ?>
                    <center>
                        <h4 style="color:#fff">Nenhuma mesa cadastrada</h4>
                        <button type="button" class="btn btn-info" onclick="location.href='../cadastro/mesa.php'"><span class="glyphicon glyphicon-new" aria-hidden="true"></span> Cadastrar mesa</button>
                    </center>
                    <?php
                }
                else
                {
                    echo '<center><h3 style="color:#fff">Mesas:</h3></center>';
                    while($array_= mysqli_fetch_array($cClass->getconsulta()))
                    { 
                        if($cClass->getStatusMesa($array_['id'])==0)
                        { ?>
                            <a data-toggle="modal" href="#clientes" data-id="<?php echo $array_['id'];?>" data-descricao="<?php echo $array_['descricao'];?>" data-id_usuario="<?php echo $_SESSION['id'];?>">
                            <?php
                        }
                        else
                        { ?>
                            <a href="mesa.php?id=<?php echo $array_['id'];?>">
                            <?php
                        } ?>
                            <div class="col-xs-6 col-md-3">
                                <?php if($cClass->getStatusMesa($array_['id'])==0) echo '<div class="panel status panel-success">';
                                else echo '<div class="panel status panel-danger">';?>
                                <div class="panel-heading">
                                    <h1 class="panel-title text-center"><?php echo $array_['descricao'];?></h1>
                                </div>
                                <div class="panel-body text-center">                        
                                    <?php if($cClass->getStatusMesa($array_['id'])==0) echo '<strong>Livre</strong>';
                                    else echo '<strong>Ocupada</strong>';?>
                                </div>
                            </div>
                            </div>          
                        </a>
                    <?php 
                    }
                }
            }
            if($config->getValue('modo_venda')=='pedido')
            {
                $cClass->listarPedidosCaixa('situacao','0','descricao');
                $count=0;
             ?>
                <button class="btn btn-success" data-toggle="modal" href="#clientes" data-id="" data-descricao="" data-id_usuario="<?php echo $_SESSION['id'];?>"><span class="glyphicon glyphicon-plus"></span> Novo Pedido</button>
                <br><br><div class="row">          
                    <div class="col-md-12">
                        <div class="panel panel-primary filterable">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-1">
                                        <h3 style="font-size: 110%"></h3>
                                    </div>
                                    <div class="col-md-4 col-md-offset-4">
                                        <h4>Pedidos em aberto:</h4>      
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <button id="btn-filter" class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    <div class=" table table-hover table-responsive">
                            <?php 
                            
                            if(mysqli_num_rows($cClass->getConsulta())==0)
                            {
                              ?>
                                <center><h4 style="color:#EB2626">Nenhum pedido em aberto...</h4></center>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Código" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Cliente" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Valor" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                     <tr onclick="location.href='pedido.php?id=<?php echo $array_['id'];?>'"
                                      style="cursor:hand">
                                      <td>
                                        <small style="color:#167A01;font-size: 110%"><?php echo $array_['id'];?></small>
                                      </td>
                                      <td >
                                        <small style="color:#080808;font-size: 110%"><?php if($array_['cliente']!="") echo $array_['cliente']; else echo $array_['obs'];?></small>
                                      </td>
                                      <td>
                                        <h6 style="color:#FF0000;font-size: 100%;font-weight:bold"><?php echo 'R$ '.$array_['valor']?></h6>
                                      </td>                                      
                                </tr>
                                <?php
                              }//end while
                            }  
                        ?>
                        </table>
                      </div>
                      </ul>
                  </div>
                  <div class="panel-footer">
                      <div class="row">
                          <div class="col-md-2">
                              <h4>
                                  Total: <span class="label label-info"><?php echo $count;?></span>
                              </h4>
                          </div>
                      </div>
                      
                  </div>
              </div>
            </div>
  </div>    
  <?php
            }
    ?>
    </div>
</div>
<hr>
</body>