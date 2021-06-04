<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="paneltablewithfilters.js" type="text/javascript"></script>  
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<script src="../js/funcoes_valores.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../css/bootstrap-theme.css">
<link href="paneltablewithfilters.css" rel="stylesheet"><!-- style for table panel with filters -->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Caixa</title>
    <style type="text/css">
      p.credit {
      font-size: 12px; 
      margin-bottom: 20px; 
      color: #ccc;
      width:100%;
      position: relative;
      left: 0;
      bottom: 0;
      }
      body{
        background-color: #690202;
      }
    </style>

    <script type="text/javascript">

      $(document).ready(function() 
      {
        var valorFixoaPagar=''//variavel para guardar o valor a pagar(para calcular o desconto)
        //vai ler apenas os cliques com atributo data-toggle=modal
        $('[data-toggle=modal]').click(function ()
        {
          var data_target = '';
          if (typeof $(this).data('target') !== 'undefined') 
          {
            data_target = $(this).data('target');
          }
          if(data_target=='#modalDetalhes')
          {
            
            id = $(this).data('id');
            buscaDadosBanco("statusFecharPedido","","../get/getCaixa.php?action=carregaItensNovo&idpedido="+id,"Erro","getCaixa","tabelaItens","../");            
            $("#btnFinalizarPedido").val(id);
            document.getElementById("btnFinalizarPedido").disabled=true;
          }
          else
          {
            //************************************************
            var data_id = '';
            if (typeof $(this).data('id') !== 'undefined') 
            {
              data_id = $(this).data('id');
            }
            $('#btnFechaPedido').val(data_id);
          }
          //************************************************
        });
      });

      /*FUNÇÃO PARA PERCORRER OS ITENS SELECIONADOS A PAGAR E FINALIZAR O PEDIDO*/
      function finalizarPedido()
      {
        var cont=0;
        var id=$("#btnFinalizarPedido").val();
        var table = document.getElementById("tabelaItens");
        for (var i = 1, row; row = table.rows[i]; i++) 
        {
          var selecionado=false;
          var q='';
          var v='';
          for (var j = 0, col; col = row.cells[j]; j++) 
          {
            //columns would be accessed using the "col" variable assigned in the for loop
            if(col.innerHTML.indexOf("checkthis")!=-1)
            {
              if(!(col.getElementsByClassName("checkthis")[0].disabled))
              {
                if(col.getElementsByClassName("checkthis")[0].checked)//verifica se está checado
                {
                  selecionado=true;
                  cont++;
                }
              }
            }
            if((col.className=='col-quantidade') && (selecionado))
              q=col.getElementsByClassName("form-control")[0].value;
          }
          if(selecionado)//se estiver checado atualiza o valor a pagar
          {
            var queryString="id="+row.id.substring(3)+"&quantidade_paga="+q+"&pedido_id="+id;
            buscaDados("statusFecharPedido",queryString,"../get/getCaixa.php?action=pagarItemNovo","Erro","../");
          }
        }   
        if(cont==0)
        {
          novoFecharPedido();
        }
      }

      /*FUNÇÃO PARA CHAMAR O MODAL FECHAR PEDIDO E ENVIANDO O VALOR A PAGAR*/
      function novoFinalizarPedido()
      {
        $('#fechar_pedido').modal('show');
        $('#finalizar_valorapagar').val($("#valorapagar").val());
      }


      function limpaModal()
      {
        alert("função limpa modal");
        //$("#finalizar_valorrecebido").val('');
        //$("#finalizar_troco").val('');
        var campos = ['finalizar_valorrecebido','finalizar_troco'];
        limpaCampos(campos);
        $('#fechar_pedido').modal('hide');
      }

      function removePedido(id)
      {
        $("#item-"+id).remove();
      }

      function pegaTotais()
      {
        var id=document.getElementById("btnFinalizarPedido").value;
        buscaDadosBanco("statusFinalizarPedido","","../get/getCaixa.php?action=carregaTotaisPedido&idpedido="+id,"Erro","getCaixaTotais","totais","../");
      }

      function pegaDetalhes()
      {
        var id=document.getElementById("btnFinalizarPedido").value;
        buscaDadosBanco("statusDetalhesPedido","","../get/getCaixa.php?action=carregaDetalhesPedido&idpedido="+id,"Erro","getCaixaDetalhes","detalhes_pedido","../");        
      }

      /*FUNÇÃO PARA ATUALIZAR O VALOR TOTAL A PAGAR*/
      function atualizaValoraPagar(valor)
      {

        var val=document.getElementById("valorapagar").value;
        
        val=parseFloat(val);
        valor=parseFloat(valor);
        valorFixoaPagar=valor;
        document.getElementById("porcentagem_garcom").checked=false;
        val=val+valor;
        carregaCampo('valorapagar',val.toFixed(2));
      }

      /*FUNÇÃO QUE PERCORRE TODOS OS ITENS PARA CALCULAR O VALOR A PAGAR*/
      function percorreTabela()
      {
        carregaCampo('valorapagar','0');//zera o campo valor a pagar
        var table = document.getElementById("tabelaItens");
        for (var i = 1, row; row = table.rows[i]; i++) 
        {
          var teste=false;
          var q='';
          var v='';
          for (var j = 0, col; col = row.cells[j]; j++) 
          {
            //columns would be accessed using the "col" variable assigned in the for loop
            if(col.innerHTML.indexOf("checkthis")!=-1)
            {
              if(col.getElementsByClassName("checkthis")[0].checked)//verifica se está checado
                teste=true;
            }
            if((col.className=='col-quantidade') && (teste))
              q=col.getElementsByClassName("form-control")[0].value;
            if((col.className=='col-valor') && (teste))
              v=col.innerHTML.substring(3);
          }
          if(teste)//se estiver checado atualiza o valor a pagar
            atualizaValoraPagar(q*v);
        }
      }

      /*FUNCAO PARA VERIFICAR O VALOR RECEBIDO*/
      function fecharPedido()
      {
        var valorrecebido=document.getElementById("finalizar_valorrecebido").value;
        valorrecebido=valorrecebido.replace(".","");
        valorrecebido=valorrecebido.replace(",",".");
        valorrecebido=parseFloat(valorrecebido);
        var valortotal=document.getElementById("finalizar_valorapagar").value;
        valortotal=parseFloat(valortotal);
        if(valorrecebido>=valortotal)
          finalizarPedido();
        else
        {
          var status=document.getElementById("statusFecharPedido");
          status.innerHTML="Valor insuficiente para pagar a conta!"; //+valorrecebido+" "+valortotal;
        }
      }

      /*FUNÇÃO QUE CALCULA A PORCENTAGEM DO GARÇOM E FECHA O PEDIDO*/
      function novoFecharPedido()
      {
        var id=$("#btnFinalizarPedido").val();
        var porcentagem_garcom='0';
        if(document.getElementById("porcentagem_garcom").checked)
        {
          var valor=parseFloat(document.getElementById("valorapagar").value);
          porcentagem_garcom=valor-valorFixoaPagar;
          porcentagem_garcom=porcentagem_garcom.toFixed(2);
        }
        var modo_pagamento=document.getElementById("modo_pagamento").value;
        var queryString = "id="+id+"&situacao=1"+"&porcentagem_garcom="+porcentagem_garcom;
        queryString+="&modo_pagamento="+modo_pagamento;
        buscaDados("statusFecharPedido",queryString,"../get/getPedido.php?action=fechar","Não foi possível fechar o Pedido",'../');        
      }

      function teste()
      {
        $('#fechar_pedido').modal('show');
      }

      function calculatroco()
      {
        var valorapagar = document.getElementById("finalizar_valorapagar").value;
        var valorrecebido = document.getElementById("finalizar_valorrecebido").value;
        if(valorapagar=="")
          valorapagar=0;
        if(valorrecebido=='')
          valorrecebido=0;
        valorrecebido= valorrecebido.replace(/\./g,'').replace(',', '.');
        var total=parseFloat(valorrecebido)-parseFloat(valorapagar);
        var troco = document.getElementById("finalizar_troco");
        troco.innerHTML=total.toFixed(2);
      }

      function porcentagem_garcom()
      {
        if(document.getElementById("porcentagem_garcom").checked)          
        {
          var valor=document.getElementById("valorapagar").value;
          valorFixoaPagar=valor;
          p=(parseFloat(valor)/100)*10+parseFloat(valor);
          $("#valorapagar").val(p.toFixed(2));
        }
        else
        {
          p=parseFloat(valorFixoaPagar);
          $("#valorapagar").val(p.toFixed(2)); 
        }
      }  

      function alteraSelect()
      {
        if(document.getElementById("check_comida").checked)
        {
          document.getElementById("item_comida").style.display = "inline";
          document.getElementById("item_bebida").style.display = "none";
        }
        else
        {
          document.getElementById("item_bebida").style.display = "inline";
          document.getElementById("item_comida").style.display = "none";
        }
      }   

      /*FUNÇÃO PARA ADICIONAR UM PRODUTO AO PEDIDO ATUAL*/
      function adicionaProduto()
      {
        var currentdate = new Date(); 
        var year = currentdate.getFullYear();
        var month = currentdate.getMonth() + 1;
        var day= currentdate.getDate();
        var hours = currentdate.getHours();
        var minutes = currentdate.getMinutes();
        var seconds = currentdate.getSeconds();
        var hora= year+"/"+month+"/"+day+" "+hours+":"+minutes+":"+seconds;
        if(document.getElementById("check_comida").checked)
        {
          var id = document.getElementById("item_comida").value;
          var campos = ['quantidade','item_comida'];
        }
        else
        {
          var id = document.getElementById("item_bebida").value;
          var campos = ['quantidade','item_bebida'];
        }
        var quant=document.getElementById("quantidade").value;
        var idpedido=document.getElementById("btnFinalizarPedido").value;
        var queryString = "item_cardapio_id="+id+"&quantidade="+quant+"&situacao=1&pedido_id="+idpedido+"&hora="+hora;
        if(validaCampos(campos))
          buscaDados("statusAdicionar",queryString,"../get/getItemCardapio.php?action=inserirnopedido","Não foi possível adicionar o item","../");
      }

      function imprimir()
      {
        var idpedido=$("#btnFinalizarPedido").val();
        var queryString = "idpedido="+id;
        buscaDados("statusFecharPedido",queryString,"../get/getPedido.php?action=imprimir","Não foi possível imprimir o Pedido",'');
      }

    </script>

</head>
<body>
<?php
  include_once('../classes/Ini.class.php');
  $config = new IniParser( '../config.ini' );
  ?>
<!-- MODAL DETALHES PEDIDO -->
    <div class="row">
      <div class="modal fade" id="modalDetalhes" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="panel panel-warning">
                  <div class="panel-heading">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                      <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Detalhes do Pedido:</h4>
                  </div>
                      <div class="modal-body">
                        <div id="detalhes_pedido" class="row">
                        </div>
                        <center><div id='statusDetalhesPedido'></div></center>
                        <div class="row">
                        <h4>Quais itens serão pagos?</h4>
                              <div class="col-md-12">
                                <div class="table-responsive">
                                  <table id="tabelaItens" class="table table-bordred table-striped">
                                    <thead>                   
                                      <th><input type="checkbox" id="checkall" /></th>
                                      <th><small>Quant.</small></th>
                                      <th><small>Quant. a ser paga</small></th>
                                      <th>Item</th>
                                      <th>Mesa</th>
                                      <th>Pedido</th>
                                      <th>Valor Unitário</th>
                                    </thead>
                                    <tbody>      
                                      <tr>
                                        <td><div class="col-md-1"><input type="checkbox" class="checkthis" /></div></td>
                                        <td><div class="col-md-2">5</div></td>
                                        <td>
                                          <div class="input-group" style="max-width:130px">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                                  <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="text" name="quant[2]" class="form-control input-number" value="5" min="1" max="5">
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                                <span class="glyphicon glyphicon-plus"></span>
                                              </button>
                                            </span>
                                          </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      </tr>    
                                    </tbody>
                                  </table>  
                                  <div class="clearfix"></div>
                                </div>
                              </div>
                          <br><br>
                          <center><div id='statusFinalizarPedido'></div></center>
                      </div>  
                    </div>
                      <div class="modal-footer">
                        <!--<div class="pull-left">
                          
                        </div>-->
                        
                          <!--<div class="col-lg-6 col-md-6 col-sm-6">
                              <span class="help-block">Garçom(+10%):</span>
                              <input id="porcentagem_garcom" type="checkbox" class="form-control" style="cursor:hand" onchange="porcentagem_garcom()">
                          </div>-->
                          <div>
                          <div id="totais" class="row" style="padding-bottom: 10px; margin-right: -290px">
                            <!--<div class="col-lg-2 col-md-2 col-sm-2">
                              <span class="help-block">Total:</span>
                              <input id="total" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <span class="help-block">Valor Pago:</span>
                              <input id="valorpago" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <span class="help-block">Valor a Pagar:</span>
                              <input id="valorapagar" type="text" class="form-control">
                            </div>-->
                        </div>

                        <div class="row">
                          <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                          <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                          <button  type="button" class="btn btn-warning" onclick="imprimir()"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                          <button id="btnFinalizarPedido" type="button" class="btn btn-success" onclick='novoFinalizarPedido()' disabled><span class="glyphicon glyphicon-ok"></span> Fechar Pedido</button>
                          </div>
                        </div>

                      </div>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div><!-- /.row -->

<!-- MODAL FECHAR PEDIDO -->
    <div class="row">
      <div class="modal fade" id="fechar_pedido" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-primary">
                  <div class="panel-heading">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                      <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-list-alt"></span> Fechar Pedido:</h4>
                  </div>
                  <form id="fechar_pedido_form" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                        <center><h4>Pagamento do pedido</h4></center>
                          <br><br>
                            <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                                <span class="help-block">Método de Pagamento:</span>
                                <select id="modo_pagamento" name="modo_pagamento" class="form-control" required="required">
                                  <option value="0">Dinheiro</option>
                                  <option value="1">Crédito</option>
                                  <option value="2">Débito</option>
                                <select>
                              </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                              <span class="help-block">Valor a Pagar:</span>
                              <input type="text" class="form-control" name="finalizar_valorapagar" id="finalizar_valorapagar" disabled/>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                              <span class="help-block">Valor Recebido:</span>
                              <input type="text" class="form-control" name="nome" id="finalizar_valorrecebido" focused onKeydown="Formata(this,20,event,2)" onkeyup="calculatroco()"/>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 pull-right" style="padding-bottom: 10px;">
                              <span class="help-block">Troco:</span>
                              <h3 id="finalizar_troco" style="padding-bottom: 10px;color:red">0.00</h3>
                            </div>
                          </div>
                          <center><div id='statusFecharPedido'></div></center>
                      </div>  
                      <div class="modal-footer">
                        <div class="pull-right">
                          <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                          <button id="btnFechaPedido" type="button" class="btn btn-success" onclick='fecharPedido()' ><span class="glyphicon glyphicon-ok"></span> Fechar Pedido</button>                                                      
                        </div>
                      </div>
                  </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div><!-- /.row -->

<!-- MODAL LISTAR ITENS CARDAPIO -->
    <div class="row">
      <div class="modal fade" id="lista_itens_cardapio" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="panel panel-warning">
            <div class="row">          
            <div class="col-md-12">
              <form id="credorForm" accept-charset="utf-8">
                <div class="modal-body" style="padding: 5px;">
                  <div class="panel panel-primary filterable">
                      <div class="panel-heading">
                        <div class="row">
                          <center>
                            <h3 style="font-size: 110%">Selecione um item:</h3>
                          </center>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-md-2">
                            <input type="radio" id="check_comida" name="item" value="0" class="form-control" checked onchange="alteraSelect()">Comida
                          </div>
                          <div class="col-md-2">
                            <input type="radio" id="check_bebida" name="item" value="1" class="form-control" onchange="alteraSelect()" >Bebida
                        </div>
                        </div><br><br>
                        <div class="row">
                          <select id="item_comida" name="item_comida" class="form-control" required="required" onchange="focusElement('quantidade')">
                            <option value="" selected>Selecione...</option>
                            <?php
                              $cClass->pesquisartabela('item_cardapio','categoria','1');
                              if(0<>mysqli_num_rows($cClass->getconsulta()))
                              {
                                while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                {
                                  if(($array_['item_tele']=='0')||($array_['item_tele']=='2'))
                                  {?>
                                  <option value="<?php echo $array_['id'];?>"><?php echo $array_['descricao'];?></option>
                                <?php }}
                              }?>
                          </select>
                          <select id="item_bebida" name="item_bebida" class="form-control" required="required" onchange="focusElement('quantidade')" style="display:none">
                            <option value="" selected>Selecione...</option>
                            <?php
                              $cClass->pesquisartabela('item_cardapio','categoria','2');
                              if(0<>mysqli_num_rows($cClass->getconsulta()))
                              {
                                while($array_= mysqli_fetch_array($cClass->getconsulta()))
                                {
                                  if(($array_['item_tele']=='0')||($array_['item_tele']=='2'))
                                  {?>
                                  <option value="<?php echo $array_['id'];?>"><?php echo $array_['descricao'];?></option>
                                <?php }}
                              }?>
                          </select>
                        </div>
                        <div class="row">
                          <div class="col-lg-2 col-md-2 col-sm-2">
                            <span class="help-block">Quantidade</span>
                            <input type="number" class="form-control" id="quantidade"/>
                          </div>
                        </div>
                      </div>
                      <div class="panel-footer">
                          <div class="row">
                              <div class="col-lg-2 col-md-2 col-sm-2">
                                  <button type="button" class="btn btn-primary" onclick="adicionaProduto()">Adicionar ao pedido</button>
                              </div>
                              <div class="col-lg-2 col-md-2 col-sm-2 pull-center" id="statusAdicionar"></div>
                          </div>
                      </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
          </div>
      </div>
    </div>

<div class="container">

<center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Modo Caixa</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
  </div><br>
  <div class="row">          
            <div class="col-md-12">
              <div class="panel panel-primary filterable">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-1">
                        <h3 style="font-size: 110%"></h3>
                      </div>
                      <div class="col-md-4 col-md-offset-3">
                            <h4>Pedidos em aberto... </h4>      
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
                            $cClass->listarPedidosCaixa('situacao','0','descricao');
                            $count=0;
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
                                    <?php if($config->getValue('modo_venda')=='mesa'){ 
                                      echo '<th><input type="text" class="form-control" placeholder="Mesa" disabled></th>';} 
                                      else{ echo '<th><input type="text" class="form-control" placeholder="Código do Pedido" disabled></th>';} ?>
                                      <th><input type="text" class="form-control" placeholder="Responsável" disabled></th>
                                      <th><input type="text" class="form-control" placeholder="Valor" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                     <tr id="item-<?php echo $array_['id'];?>" data-toggle="modal" 
                                      data-target="#modalDetalhes" data-id="<?php echo $array_['id'];?>"
                                      style="cursor:hand">
                                      <td>
                                         <?php if($config->getValue('modo_venda')=='mesa'){ 
                                        echo '<small style="color:#167A01;font-size: 110%">'.$array_["descricao"].'</small>';}
                                        else {echo '<small style="color:#167A01;font-size: 110%">'.$array_["id"].'</small>';} ?>
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
</div>
<script>ativaPainelFilter();</script>
</body>