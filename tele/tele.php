<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/funcoes_valores.js" type="text/javascript"></script>
<script src="../js/bootstrap-toggle.min.js"></script>
<script src="../garcom/dual-list.js" type="text/javascript"></script>
<script src="../garcom/listgroup.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../garcom/dual-list.css">
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet"><!-- REFERENCIA AO CHECKBOX TOGGLE-->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Tele-Entrega</title>
  <meta http-equiv="Content-Type" content="text/html;">
    <style type="text/css">
        body{
        background-color: #690202;
      }
    </style>

    <script type="text/javascript">
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
                var data_descricao = '';
                if (typeof $(this).data('descricao') !== 'undefined') 
                {
                    data_descricao = $(this).data('descricao');
                }
                $('#descricao_delete').val(data_descricao);
                //************************************************
            });

            $('#cbxTaxa').change(function() {
                habilitaTaxaTele();
            });
            habilitaTaxaTele();
        });

        function okquantidade(id)
        {
            var quantidade=document.getElementById("quantidade_item").value;
            var situacao=0;
            var pedido_id=<?php echo $_GET['id'];?>;
            var queryString = "item_cardapio_id="+id+"&quantidade="+quantidade+"&situacao="+situacao+"&pedido_id="+pedido_id;
            buscaDados("statusCadastro",queryString,"../get/getItemCardapio.php?action=inserirnatele","Não foi possível adicionar o item","../");
        }

        function adicionarItem()
        {
            var elements=document.getElementsByClassName("lgi active");
            var quantidade=document.getElementById("quantidade_item").value;
            var obs=document.getElementById("observacoes_item").value;
            for( i=0; i < elements.length; i++)
            {
              var item=elements[i].getAttribute("id");
              var descricao=document.getElementById(item).innerHTML;
              item=item.substring(5);
              //alert(item);
              //adiciona um item a lista do pedido
              var ul = document.getElementById("contact-list");

              if(ul==null)//se nao tiver nenhum item no pedido cria o list
              {
                var ul=document.createElement("ul");
                ul.setAttribute("class","list-group");
                ul.setAttribute("id","contact-list");
                var row=document.getElementById("detail-1");
                row.innerHTML="<br><hr>";
                row.appendChild(ul);
              }

              var li = document.createElement("a");
              li.setAttribute("class","list-group-item list-group-item-warning itt");
              //ADICIONA O ID DO ITEM E A QUANTIDADE E OBS PELO ATRIBUTO DATA-
              li.setAttribute("data-id",item);
              li.setAttribute("data-quantidade",quantidade);
              li.setAttribute("data-obs",obs);
              var div = document.createElement("div");
              div.setAttribute("class","col-xs-12 col-sm-9");

              div.innerHTML='<h5>'+quantidade+' x '+descricao+'</h5>';
              var div2 = document.createElement("div");
              div2.setAttribute("class","clearfix");
              li.appendChild(div);
              li.appendChild(div2);
              ul.appendChild(li);                 
            }
            $('#itens').modal('hide');            
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

        function salvarTele(idtele)
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
                var id = elements[i].getAttribute('data-id');
                var quant=elements[i].getAttribute('data-quantidade');
                var obse=elements[i].getAttribute('data-obs');
                var queryString = "item_cardapio_id="+id+"&quantidade="+quant+"&tele_id="+idtele+"&obs="+obse;
                buscaDados("statusCadastro",queryString,"../get/getItemCardapio.php?action=inserirnatele","Não foi possível adicionar o item","");
            }
            if(document.getElementById("cbxTaxa").checked)
              var queryString2="taxa="+document.getElementById("inpTaxaTele").value;
            else
              var queryString2="taxa=0";
            queryString2+="&id="+idtele;
            //alert(queryString2);
            buscaDados("statusCadastro",queryString2,"../get/getTele.php?action=taxaTele","Não foi possível alterar a taxa da Tele","true");
        }

        function excluir(idtele)
        {
            var id=document.getElementById("id_delete").value;
            var queryString="id="+id+"&tele_id="+idtele;
            //alert(queryString);
            buscaDados("statusExcluir",queryString,"../get/getTeleHasItemCardapio.php?action=delete","Não foi possível remover o item","true");
        }

        function habilitaTaxaTele()
        {
          if(document.getElementById("cbxTaxa").checked)
            document.getElementById("inpTaxaTele").disabled=false;
          else
            document.getElementById("inpTaxaTele").disabled=true;
        }

        function focusElement(id)
        {
            document.getElementById(id).focus();
        }

        function imprime(idtele)
        {
          window.open("../nfiscal/imprime_tele.php?idtele="+idtele,"_blank");
        }

    </script>
</head>
<body>
  <?php
  include_once '_modal_itens.html';
  ?>
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

    <!-- MODAL EDITAR TELE-->
    <div class="row">
      <div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Editar Pedido</h4>
                  </div>
                  <form id="formEditarTele" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Detalhes da Tele:</h4>
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
                              <div class="row">
                                <div class="col-md-12">
                                  <span class="help-block">Observações:</span>
                                      <textarea type="text" class="form-control" id="obs_detalhes"><?php echo $cClass->pesquisaCampo('pedido','obs',$_GET['id']); ?></textarea>               
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
            <a href="../tele" class="btn btn-default"><div>Modo Tele-Entrega</div></a>
            <a href="#" class="btn btn-default active"><div>Tele-Entrega</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
  </div><br>
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading c-list">
            <div class="row">
                <div class="pull-left" style="font-size: 150%;color:#00A600">
                    <?php $date=date_create($cClass->pesquisaCampo('tele','data_tele',$_GET['id']));
                          echo date_format($date,'d/m/y');
                          ?>
                </div>
                <div class="pull-right" style="font-size: 150%;color:#FF0000">
                    <?php $num=$cClass->pesquisaCampo('tele','valor',$_GET['id']);
                          $taxa=$cClass->pesquisaCampo('tele','taxa',$_GET['id']);
                    echo 'TOTAL: R$ '. number_format($num+$taxa, 2); ?>
                </div>
                <center><h3>Tele-Entrega Nº: <?php echo $_GET['id'];?></h3></center>
                <center><h5>Cliente: <?php echo $cClass->pesquisaCampo('cliente','nome',$cClass->pesquisaCampo('tele','cliente_id',$_GET['id']));?></h5></center>                
            </div>
            <div class="row">
                <button type="button" class="btn btn-success pull-center" data-toggle="modal" data-target="#itens"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Item</button>
            </div>
          </div>
          <div class="panel-body" >
            <!--<ul class="list-group-i" style="margin-left:-40px">-->
              <!--<li class="list-group-item" >-->
                <div id="detail-1">
                    <?php $cClass -> listarItensTeleTodos($_GET['id']);
                      if(0==mysqli_num_rows($cClass->getconsulta()))
                        echo '<br><center>Ainda não há itens nesta Tele-Entrega</center><hr>';
                      else
                      {
                        echo '<br><hr>';
                        echo '<ul class="list-group-i" id="pedido">';
                        while($array_= mysqli_fetch_array($cClass->getconsulta()))
                        {?>
                          <a class="list-group-item list-group-item-warning">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-7">
                                  <h5><?php echo $array_['quantidade'];?> x <?php echo $array_['descricao'];?></h5>
                                </div>
                                <div class="col-md-3">
                                  <h4><?php $num = $array_['quantidade']*$array_['valor'];
                                      echo 'R$  ' . number_format($num, 2); ?>
                                  </h4>
                                </div>
                                <div class="col-md-2">
                                  <button data-toggle="modal" 
                                    data-target="#delete" data-id="<?php echo $array_['id'];?>"
                                    data-descricao="<?php echo utf8_encode($array_['descricao']);?>" 
                                    class="btn btn-danger" style="margin:0px 0px 6px 6px">
                                    <span class="glyphicon glyphicon-trash"></span>
                                  </button>
                                </div>
                              </div>
                            </div>
                            <div class="clearfix"></div>
                          </a>
                        <?php }//end while
                        echo '</ul>';
                      }//end else?>
                </div>
              <!--</li>-->
            <!--</ul>-->
            </div>
            <div class="panel-footer">
              <div id="statusCadastro"></div>  
              <div class="row">
                <div class="col-md-3">
                    <input id="cbxTaxa" type="checkbox" data-toggle="toggle" data-on="Taxa de Entrega" data-off="Taxa de Entrega" data-size="medium" data-style="slow" onchange="habilitaTaxaTele()"  <?php if($taxa>0) echo 'checked'; ?>/>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="inpTaxaTele" value="<?php echo $taxa;?>" onKeydown="Formata(this,20,event,2)" placeholder="Taxa R$"/>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-warning btn-block" onclick="editarTele('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-edit"></span> Editar Tele-Entrega </button>
                </div>
                <!--<div class="col-md-4">            
                    <button type="button" class="btn btn-primary btn-block btn-lg" onclick="imprime('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                </div>-->
                <div class="col-md-4">            
                    <button type="button" class="btn btn-success btn-block" onclick="salvarTele('<?php echo $_GET['id'];?>')"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar Tele-Entrega </button>
                </div>
              </div>            
            </div>
        </div>
    </div>
  </div>
</div>
</div>
</body>