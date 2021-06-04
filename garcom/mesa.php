<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<script src="dual-list.js" type="text/javascript"></script>
<script src="listgroup.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="dual-list.css">
<link rel="stylesheet" href="../css/event-list.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
    <title>FoodControl - Garçom</title>
    <style type="text/css">
        body{
        background-color: #690202;
      }

      li { cursor: pointer; cursor: hand; }
    </style>
    <script type="text/javascript">
        function salvaPedido(cliente_id,mesa_id,usuario_id)
        {
            //var nome = document.getElementById('nome_novo').value;
            var situacao = 0;
            var valor=0;
            var currentdate = new Date(); 
            var data_pedido= currentdate.getFullYear() +"/"+ (((currentdate.getMonth()+1) < 10)?"0":"") + (currentdate.getMonth()+1) +"/"+ ((currentdate.getDate() < 10)?"0":"") + currentdate.getDate();
            
            var queryString = "mesa_id="+mesa_id+"&situacao="+situacao;
            queryString+="&valor="+valor+"&data_pedido="+data_pedido+"&usuario_id="+usuario_id+"&cliente_id="+cliente_id;

            buscaDados("statusCadastro",queryString,"../get/getPedido.php?action=new","Não foi possível cadastrar",'../');
        }

        $(document).ready(function() {

            //carregar o modal #delete
            $('[data-toggle=modal]').click(function ()
            {
                //************************************************
                var data_id = '';
                if (typeof $(this).data('id') !== 'undefined') 
                {
                    data_id = $(this).data('id');
                }
                $('#id_delete').val(data_id);
                //************************************************
                var data_nome = '';
                if (typeof $(this).data('nome') !== 'undefined') 
                {
                    data_nome = $(this).data('nome');
                }
                $('#nome_delete').val(data_nome);
                //************************************************
            });

        });

        function excluir()
        {
            var id=document.getElementById("id_delete").value;
            var queryString="id="+id;
            //alert(queryString);
            buscaDados("statusExcluir",queryString,"../get/getPedido.php?action=delete","Não foi possível excluir o pedido","true");
        }

        function selecionaCliente(id,mesa_id,usuario_id)
        {
          salvaPedido(id,mesa_id,usuario_id);
          //alert('cliente='+id);
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
  ?>
<div class="row">

    <!-- MODAL EXCLUIR PEDIDO -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Excluir Pedido?</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o deste Pedido?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="nome_delete" id="nome_delete" disabled/>
                                  </div>
                              </div>
                              <br><br>
                              <center><div id='statusExcluir'></div></center>
                          </div>  
                          <div class="modal-footer">
                              <button  type="button" class="btn btn-lg btn-block btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-lg btn-block btn-danger" onclick="excluir()" ><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

<div class="container">
    <center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="index.php" class="btn btn-default"><div>Modo Garçom</div></a>
            <a href="#" class="btn btn-default active"><div>Mesa</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>

      <div class="row">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading c-list">
                    <center><h3>Pedidos Mesa <?php echo $cClass->pesquisaCampo('mesa','descricao',$_GET['id'])?>:</h3></center>
                </div>
                <?php 
                    
                    /*
                    $cClass -> listarPedidosGarcom($_GET['id']);
                    if(0<>mysqli_num_rows($cClass->getconsulta()))
                    {
                        while($array_= mysqli_fetch_array($cClass->getconsulta()))
                        {?>
                            <ul class="list-group-i" id="contact-list">
                                <div class="row">
                                    <div class="col-xs-10 col-sm-9">
                                    <a href="pedido.php?id=<?php echo $array_['id'];?>" class="list-group-item list-group-item-default">
                                        <h3><?php echo $array_['nome'];?><br/>
                                        <span class="label label-danger row pull-right" style="font-size: 80%;">
                                            <span class="glyphicon glyphicon-usd"></span>    
                                            <span><?php echo $array_['valor'];?></span>
                                        </span>
                                        </h3>
                                        <div class="clearfix"></div>
                                    </a>
                                    </div>
                                    <div class="col-xs-2 col-sm-3">
                                        <button data-toggle="modal" 
                                            data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                            data-nome="<?php echo $array_['nome'];?>" 
                                            class="btn btn-danger btn-lg" style="margin:50px 0px 0px -25px">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </ul>
                        <?php
                        }
                    }
                    */

                    $cClass -> listarPedidosGarcom($_GET['id']);
                    if(0<>mysqli_num_rows($cClass->getconsulta()))
                    {
                        echo '<ul class="event-list">';
                        while($array_= mysqli_fetch_array($cClass->getconsulta()))
                        {?>
                              <li>

                                <time datetime="2014-07-20">
                                  <span class="day"><?php echo $array_['id'];?></span>
                                  <!--<span class="month">Jul</span>
                                  <span class="year">2014</span>
                                  <span class="time">ALL DAY</span>-->
                                </time>
                                <!--<img alt="Independence Day" src="https://farm4.staticflickr.com/3100/2693171833_3545fb852c_q.jpg" />-->
                                <div class="info"  onclick="location.href='pedido.php?id=<?php echo $array_['id'];?>'" >
                                  <h2 class="title"><?php echo $array_['nome'];?></h2>
                                  <p class="desc"><?php echo $array_['obs'];?></p>
                                  <ul>
                                    <li style="width:50%;"><span class="fa fa-user"></span><?php echo $array_['login'];?></li>
                                    <li style="width:50%;"><span class="fa fa-money"></span>R$ <?php echo ' '.$array_['valor'];?></li>
                                  </ul>
                                </div>
                                <div class="social">
                                  <ul>
                                  <li class="deletar" ><a href="#" data-toggle="modal" 
                                            data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                            data-nome="<?php echo $array_['nome'];?>"><span class="glyphicon glyphicon-trash"></span></a></li>
                                    <!--<button data-toggle="modal" 
                                            data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                            data-nome="<?php echo $array_['nome'];?>" 
                                            class="btn btn-danger btn-lg" style="margin:50px 0px 0px -25px">
                                          <span class="glyphicon glyphicon-trash"></span>
                                    </button>--></ul></div>
                                <!--<div class="social">
                                  <ul>
                                    <li class="facebook" style="width:33%;"><a href="#facebook"><span class="fa fa-facebook"></span></a></li>
                                    <li class="twitter" style="width:34%;"><a href="#twitter"><span class="fa fa-twitter"></span></a></li>
                                    <li class="google-plus" style="width:33%;"><a href="#google-plus"><span class="fa fa-google-plus"></span></a></li>
                                  </ul>
                                </div>-->
                              </li>  
                        <?php
                        }
                    }

                ?>
                
            </div>



            <center>
                <!--<a data-toggle="modal" href="#modalNomePedido" class="list-group-item list-group-item-success" style="font-size: 150%;" onclick="focusElement('nome_novo');">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Pedido 
                </a>-->
                <a data-toggle="modal" href="#clientes" class="list-group-item list-group-item-success" style="font-size: 150%;">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo Pedido 
                </a>
            </center>
        </div>
    </div>      
</div>
</body>