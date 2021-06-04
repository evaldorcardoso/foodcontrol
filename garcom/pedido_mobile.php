<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Pedido</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        body{
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
                var data_descricao = '';
                if (typeof $(this).data('descricao') !== 'undefined') 
                {
                    data_descricao = $(this).data('descricao');
                }
                $('#descricao_delete').val(data_descricao);
                //************************************************
            });
		});

		function okquantidade(id)
		{
            var quantidade=document.getElementById("quantidade_item").value;
            var situacao=0;
            var pedido_id=<?php echo $_GET['id'];?>;
            var queryString = "item_cardapio_id="+id+"&quantidade="+quantidade+"&situacao="+situacao+"&pedido_id="+pedido_id;
            buscaDados("statusCadastro",queryString,"../get/getItemCardapio.php?action=inserirnopedido","Não foi possível adicionar o item","../");            
		}

        function adicionarItem(tipo)
        {
            if(tipo=='comida')
            {
                var iditem=document.getElementById('item_comida').value;
                var item=$('#item_comida option:selected').text();
                var quantidade=document.getElementById('quantidade_comida').value;
                var obs=document.getElementById('obs_comida').value;
                if((iditem=='')||(quantidade=='')||(quantidade=='0')||(quantidade<0))
                {
                    return;
                }
               //adiciona um item a lista do pedido
                var ul = document.getElementById("contact-list");
                if(ul==null)
                {
                    var ul=document.createElement("ul");
                    ul.setAttribute("class","list-group");
                    ul.setAttribute("id","contact-list");
                    var row=document.getElementById("row-comida");
                    row.appendChild(ul);
                }
                var li = document.createElement("a");
                li.setAttribute("class","list-group-item list-group-item-warning itt");
                //ADICIONA O ID DO ITEM E A QUANTIDADE E OBS PELO ATRIBUTO DATA-
                li.setAttribute("data-id",iditem);
                li.setAttribute("data-quantidade",quantidade);
                li.setAttribute("data-obs",obs);
                var div = document.createElement("div");
                div.setAttribute("class","col-xs-12 col-sm-9");
                
               
                div.innerHTML='<h3>'+quantidade+' x '+item+'</h3>';
                var div2 = document.createElement("div");
                div2.setAttribute("class","clearfix");
                li.appendChild(div);
                li.appendChild(div2);
                ul.appendChild(li);                 
                //limpar o select e o quantidade e obs
                $("#item_comida").val('');
                $("#quantidade_comida").val('');
                $("#obs_comida").val('');
            }
            else
            {

                var iditem=document.getElementById('item_bebida').value;
                var item=$('#item_bebida option:selected').text();
                var quantidade=document.getElementById('quantidade_bebida').value;
                var obs=document.getElementById('obs_bebida').value;
                if((iditem=='')||(quantidade=='')||(quantidade=='0')||(quantidade<0))
                {
                    return;
                }
                //alert('else');
               //adiciona um item a lista do pedido
                var ul = document.getElementById("contact-list-bebida");
                if(ul==null)
                {
                    var ul=document.createElement("ul");
                    ul.setAttribute("class","list-group");
                    ul.setAttribute("id","contact-list-bebida");
                    var row=document.getElementById("row-bebida");
                    row.appendChild(ul);
                }
                var li = document.createElement("a");
                li.setAttribute("class","list-group-item list-group-item-warning itt");
                //ADICIONA O ID DO ITEM E A QUANTIDADE E OBS PELO ATRIBUTO DATA-
                li.setAttribute("data-id",iditem);
                li.setAttribute("data-quantidade",quantidade);
                li.setAttribute("data-obs",obs);
                var div = document.createElement("div");
                div.setAttribute("class","col-xs-12 col-sm-9");
                
               
                div.innerHTML='<h4>'+item+'</h4><h4><span>'+quantidade+' x</span></h4>';
                var div2 = document.createElement("div");
                div2.setAttribute("class","clearfix");
                li.appendChild(div);
                li.appendChild(div2);
                ul.appendChild(li);                 
                //limpar o select e o quantidade e obs
                $("#item_bebida").val('');
                $("#quantidade_bebida").val('');
                $("#obs_bebida").val('');
            }
        }

        function seleciona_produto(iditem)
        {
            var a = document.createElement("a");
            a.setAttribute("id","clique");
            a.setAttribute("data-toggle","modal");
            a.setAttribute("href","#modalQuantidade");
            document.body.appendChild(a);
            a.click();
            $("#okquantidade").attr("onclick","okquantidade('"+iditem+"')");
        }

        function salvarPedido(idpedido)
        {
            //var element = $('a[data-id]');
            var elements=document.getElementsByClassName("itt");
            var currentdate = new Date(); 
            var year = currentdate.getFullYear();
            var month = currentdate.getMonth() + 1;
            var day= currentdate.getDate();
            var hours = currentdate.getHours();
            var minutes = currentdate.getMinutes();
            var seconds = currentdate.getSeconds();
            var hora= year+"/"+month+"/"+day+" "+hours+":"+minutes+":"+seconds;
            for( i=0; i < elements.length; i++ )
            {
                //alert(elements[i].getAttribute('data-id'));
                var id = elements[i].getAttribute('data-id');
                var quant=elements[i].getAttribute('data-quantidade');
                var obse=elements[i].getAttribute('data-obs');
                var queryString = "item_cardapio_id="+id+"&quantidade="+quant+"&situacao=0&pedido_id="+idpedido+"&hora="+hora+"&obs="+obse;
                buscaDados("statusCadastro",queryString,"../get/getItemCardapio.php?action=inserirnopedido","Não foi possível adicionar o item","../");
            }
            if(elements.length==0)
            {
                alert("O pedido já está salvo!");
            }
        }

        function editarPedido(id)
        {
            $("#modal_editar").modal('show');
        }

        function editar(id)
        {
            var responsavel=document.getElementById("nome_detalhes").value;
            var mesa_id=document.getElementById("mesa_detalhes").value;
            var queryString="id="+id+"&nome="+responsavel+"&mesa_id="+mesa_id;
            buscaDados('statusDetalhes',queryString,'../get/getPedido.php?action=editar','Não foi possível salvar as alterações','../');
        }

        function excluir(idpedido)
        {
            var id=document.getElementById("id_delete").value;
            var queryString="id="+id+"&pedido_id="+idpedido;
            buscaDados("statusExcluir",queryString,"../get/getPedidoHasItemCardapio.php?action=delete","Não foi possível remover o item","../");
        }

        function focusElement(id)
        {
            document.getElementById(id).focus();
        }

        function imprime(idpedido)
        {
          window.open("../nfiscal/imprime_pedido.php?idpedido="+idpedido,"_blank");
        }

    </script>
</head>
<body>
<div class="row">
<div class="container">

    <!-- MODAL EXCLUIR ITEM -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Excluir Item do Pedido?</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o deste Item?</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="id_delete" id="id_delete" disabled/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <input type="text" class="form-control" name="descricao_delete" id="descricao_delete" disabled/>
                                  </div>
                              </div>
                              <br><br>
                              <center><div id='statusExcluir'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <!--<div class="pull-right">-->
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-lg btn-block btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-lg btn-block btn-danger" onclick="excluir('<?php echo $_GET["id"];?>')" ><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                            <!--</div>-->
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

    <!-- MODAL EDITAR PEDIDO-->
    <div class="row">
      <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Editar Pedido</h4>
                  </div>
                  <form id="formEditarPedido" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Detalhes do Pedido:</h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Código</span>
                                      <input type="text" class="form-control" id="id_detalhes" disabled value="<?php echo $_GET['id'];?>"/>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6" style="padding-bottom: 10px;">
                                      <span class="help-block">Responsável</span>
                                      <input type="text" class="form-control" id="nome_detalhes" value="<?php echo $cClass->pesquisaCampo('pedido','nome',$_GET['id']); ?>"/>
                                  </div>
                                  <div class="col-lg-4 col-md-12 col-sm-6" style="padding-bottom: 10px;">
                                      <span class="help-block">Mesa</span>
                                      <select class="form-control" id="mesa_detalhes">
                                        <?php
                                            $selected=$cClass->pesquisaCampo('pedido','mesa_id',$_GET['id']);
                                            $mesas=$cClass->listar2('mesa','id');
                                            while($array_=mysqli_fetch_array($mesas))
                                            {
                                                if($selected==$array_['id'])
                                                    echo '<option value="'.$array_['id'].'" selected>'.$array_['descricao'].'</option>';
                                                else
                                                    echo '<option value="'.$array_['id'].'">'.$array_['descricao'].'</option>';
                                            }
                                        ?>
                                        
                                      </select>
                                  </div>
                              </div>
                              <br><br>
                              <center><div id='statusDetalhes'></div></center>
                          </div>  
                          <div class="modal-footer">
                              <button  type="button" class="btn btn-lg btn-block btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-lg btn-block btn-success" onclick="editar('<?php echo $_GET["id"];?>')" ><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

     <center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="index.php" class="btn btn-default"><div>Modo Garçom</div></a>
            <a href="#" class="btn btn-default"><div>Mesa</div></a>
            <a href="#" class="btn btn-default active"><div>Pedido</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>

    <div class="panel panel-default">
        <div class="panel-heading c-list">
                    <center>
                        <div class="row">
                            <h3>Pedido <?php echo $_GET['id'];?>:</h3><p>
                            <?php echo '<h5>'.$cClass->pesquisaCampo('pedido','nome',$_GET['id']).'</h5><p>'; ?>
                            <div class="pull-left" style="font-size: 150%;">
                                <?php echo date("d-m-Y");?>
                            </div>
                            <div class="pull-right" style="font-size: 150%;">
                                <?php $num=$cClass->pesquisaCampo('pedido','valor',$_GET['id']);
                                echo 'TOTAL: R$ '. number_format($num, 2); ?>
                            </div>
                        </div>
                    </center>
        </div>  
        <ul class="list-group">
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                    <div class="col-xs-10">
                        <h2><span class="glyphicon glyphicon-cutlery"></span> Comida</h2>
                    </div>
                    <div class="col-xs-2"><i class="glyphicon glyphicon-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-1">
                    <hr></hr>
                    <!--<div class="container">-->
                        <div id="row-comida" class="row">
                            <div>
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                    <select id="item_comida" name="item_comida" class="form-control" required="required" onchange="focusElement('quantidade_comida')" style="height:60px">
                                      <option value="" selected>Selecione...</option>
                                      <?php
                                        $cClass->pesquisartabela('item_cardapio','categoria','1');
                                        if(0<>mysqli_num_rows($cClass->getconsulta()))
                                        {
                                            while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                            {
                                              if($array_['item_tele']=='0')
                                              {
                                              ?>
                                                <option value="<?php echo $array_['id'];?>"><?php echo $array_['descricao'];?></option>
                                      <?php }}
                                        }?>
                                    </select>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <input id="quantidade_comida" class="form-control" type="number" placeholder="Quantidade" style="height:60px"/>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <input id="obs_comida" class="form-control" type="text" placeholder="Observações" style="height:60px"/>
                                    </div>
                                </div>
                            </div><br>                            
                            <center>
                				<a onclick="adicionarItem('comida')" class="list-group-item list-group-item-success" style="font-size:150%; height:60px"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Adicionar Item </a>
            				</center>
                            
                            <?php
                            $cClass -> listarItensPedidoGarcom($_GET['id'],1);
                            if(0==mysqli_num_rows($cClass->getconsulta()))
                            { 
                               echo '<br><center>Ainda não há itens neste pedido</center><hr>';
                            }
                            else
                            {
                                echo '<br><center>Itens deste pedido:</center><hr>';
                                echo '<ul class="list-group" id="contact-list">';
                                while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                {?>
                    			<a class="list-group-item list-group-item-warning">
                        		<div class="col-xs-12 col-sm-9">
                                    <div class="row">
                            		  <h3><?php echo $array_['quantidade'];?> x <?php echo $array_['descricao'];?></h3>
                                        <div class="pull-right">
		                            	 <span class="label label-danger" style="font-size: 170%;">
			                               	<span ><?php
                                                $num = $array_['quantidade']*$array_['valor'];
                                                echo 'R$  ' . number_format($num, 2); ?>
                                            </span>
		                            	</span>
                        			     <button data-toggle="modal" 
                                            data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                            data-descricao="<?php echo $array_['descricao'];?>" 
                                            class="btn btn-danger btn-lg" style="margin:0px 0px 6px 6px">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                     </div>
                                 </div>
                        		</div>
                        		<div class="clearfix"></div>
                    			</a>
                    			<?php
                                }//end while
                                echo '</ul>';
                            }//end else?>
                        </div>
                    <!--</div><!-- /container-->
                </div>
            </li>
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                    <div class="col-xs-10">
                       <h2><span class="glyphicon glyphicon-glass"></span> Bebida</h2>
                    </div>
                    <div class="col-xs-2"><i class="glyphicon glyphicon-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-2">
                    <hr></hr>
                        <div id="row-bebida" class="row">
                            <div>
                                <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                    <select id="item_bebida" name="item_bebida" class="form-control" required="required" onchange="focusElement('quantidade_bebida')" style="height:60px">
                                      <option value="" selected>Selecione...</option>
                                      <?php
                                        $cClass->pesquisartabela('item_cardapio','categoria','2');
                                        if(0<>mysqli_num_rows($cClass->getconsulta()))
                                        {
                                            while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                            {
                                              if($array_['item_tele']=='0')
                                              {
                                                ?>
                                                <option value="<?php echo $array_['id'];?>"><?php echo $array_['descricao'];?></option>
                                      <?php }}
                                        }?>
                                    </select>
                                    </div>
                                    <div class="col-xs-6 col-md-6">
                                        <input id="quantidade_bebida" class="form-control" type="number" placeholder="Quantidade" style="height:60px"/>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <input id="obs_bebida" class="form-control" type="text" placeholder="Observações" style="height:60px"/>
                                    </div>
                                </div>
                            </div><br>                            
                            <center>
                                <a onclick="adicionarItem('bebida')" class="list-group-item list-group-item-success" style="font-size:150%; height:60px"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> Adicionar Item </a>
                            </center>
                            <?php
                            $cClass -> listarItensPedidoGarcom($_GET['id'],2);
                            if(0==mysqli_num_rows($cClass->getconsulta()))
                            {
                                echo '<br><center>Ainda não há bebidas neste pedido</center><hr>';
                            }
                            else
                            {
                                echo '<br><center>Bebidas deste pedido:</center><hr>';
                                echo '<ul class="list-group" id="contact-list-bebida">';
                                while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                {?>
                                <a class="list-group-item list-group-item-warning">
                                <div class="col-xs-12 col-sm-9">
                                    <div class="row">
                                        <h3><?php echo $array_['quantidade'];?> x <?php echo $array_['descricao'];?></h3>
                                        <div class="pull-right">
                                         <span class="label label-danger" style="font-size: 170%;">
                                            <span ><?php
                                                $num = $array_['quantidade']*$array_['valor'];
                                                echo 'R$  ' . number_format($num, 2); ?>
                                            </span>
                                        </span>
                                         <button data-toggle="modal" 
                                            data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                            data-descricao="<?php echo $array_['descricao'];?>" 
                                            class="btn btn-danger btn-lg" style="margin:0px 0px 6px 6px">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                     </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                </a>
                                <?php
                                }//end while
                                echo '</ul>';
                            }//end else?>
                        </div>
                </div>
            </li>
        </ul>
	</div>
    
    <div class="col-xs-12 col-md-12">
        <center>
            <div id="statusCadastro"></div>
            <button type="button" class="btn btn-success btn-block btn-lg" onclick="salvarPedido('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar Pedido </button>
            <br>
            <button type="button" class="btn btn-default btn-block btn-lg" onclick="editarPedido('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-edit"></span> Editar Pedido </button>
            <br>
            <button type="button" class="btn btn-default btn-block btn-lg" onclick="imprime('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
            <br>
        </center>
    </div>
    <br><br>
</div>
</div>
</body>