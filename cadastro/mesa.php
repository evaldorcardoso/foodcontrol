<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>  
<script src="../js/funcoes_gerais.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
  <title>FoodControl - Mesas</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style type="text/css">
    body{
        background-color: #690202;
    }

    p.credit {
    font-size: 12px; 
    margin-bottom: 20px; 
    color: #ccc;
    width:100%;
    position: relative;
    left: 0;
    bottom: 0;
  }
    </style>
    
    <script type="text/javascript">
      function salvar()
      {
        var acao=document.getElementById('salvarButton').value;
        var id=document.getElementById('id').value;
        var descricao=document.getElementById('descricao').value;
        if(descricao!='')
        {
           var queryString = "id="+id+"&descricao="+descricao;
           buscaDados("statusCadastro",queryString,"../get/getMesa.php?action="+acao,"Não foi possível cadastrar",'../');
        }
        else
        {
         alert("Para a descrição da mesa informe somente números!");
         return;
        }
      }

      function excluir()
      {
        var id_delete=document.getElementById('id_delete').value;
        var queryString = "id="+id_delete;
        buscaDados("statusExcluir",queryString,"../get/getMesa.php?action=delete","Não foi possível excluir o item",'../');
      }

      $(document).ready(function() 
      {
          //vai ler apenas os cliques com atributo data-toggle=modal
          $('[data-toggle=modal]').click(function ()
          {
            var action='';
            if (typeof $(this).data('action') !== 'undefined') 
            {
              action = $(this).data('action');
            }
            if(action=='novo')
            {
              $('#salvarButton').val("novo");
            }
            if(action=='editar')
            {
              $('#salvarButton').val("editar");
            }
            
            //************************************************
            var data_id = '';
            if (typeof $(this).data('id') !== 'undefined') 
            {
              data_id = $(this).data('id');
            }
            $('#id_delete').val(data_id);
            $('#id').val(data_id);
            //************************************************
            var data_descricao = '';
            if (typeof $(this).data('descricao') !== 'undefined') 
            {
              data_descricao = $(this).data('descricao');
            }
            $('#descricao_delete').val(data_descricao);
            $('#descricao').val(data_descricao);
            //************************************************
          });
      });
    </script>
    <!-- style for table panel with filters -->
    <link href="../caixa/paneltablewithfilters.css" rel="stylesheet">
    <script src="../caixa/paneltablewithfilters.js" type="text/javascript"></script>  
</head>
<body>
<div class="container">
       <!-- MODAL EXCLUIR ITEM -->
    <div class="row">
      <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-unchecked"></span> Excluir Mesa:</h4>
                  </div>
                  <form id="deleteForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4>Prosseguir com a exclus&#227o desta mesa?</h4>
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
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button  type="button" class="btn btn-danger" onclick='excluir()' ><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>

    <!-- MODAL CADASTRO ITEM -->
    <div class="row">
      <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="panel panel-warning">
   
                  <div class="panel-heading">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                          <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-unchecked"></span> Cadastro de Mesa:</h4>
                  </div>
                  <form id="cadastroForm" accept-charset="utf-8">
                      <div class="modal-body" style="padding: 5px;">
                              <h4></h4>
                              <div class="row">
                                  <div class="col-lg-2 col-md-2 col-sm-2" style="padding-bottom: 10px;">
                                      <span class="help-block">Codigo:</span>
                                      <input type="text" class="form-control" name="id" id="id" disabled/>
                                  </div>
                                  <div class="col-lg-8 col-md-8 col-sm-8" style="padding-bottom: 10px;">
                                      <span class="help-block">Descricao:</span>
                                      <input type="number" class="form-control" name="descricao" id="descricao"/>
                                  </div>
                              </div>
                              <center><div id='statusCadastro'></div></center>
                          </div>  
                          <div class="modal-footer">
                            <div class="pull-right">
                              <!--<input type="submit" name="salvar" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Salvar</input>-->
                              <button  type="button" class="btn btn-default btn-close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Fechar</button>
                              <button id="salvarButton" type="button" class="btn btn-success" onclick='salvar()' value="novo"><span class="glyphicon glyphicon-floppy-disk"></span> Salvar</button>
                            </div>
                          </div>
                        </form>
              </div><!-- /.panel -->
          </div><!-- /.modal-dalog -->
      </div><!-- /.modal -->
    </div>
    
    <center>
        <h3 style="color:#ffffff; ">
          Cadastro de Mesa:
        </h3>          
      </center><hr>
      <div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Cadastro de Mesas</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
   </div><br>

      <button class="btn btn-success" data-toggle="modal" data-target="#modalCadastro" data-action="novo"><span class="glyphicon glyphicon-plus"></span> Nova Mesa</button>
          <div class="row">          
            <div class="col-md-12">
              <div class="panel panel-primary filterable">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-1">
                        <h3 style="font-size: 110%"></h3>
                      </div>
                      <div class="col-md-4 col-md-offset-3">
                            <p class="credit" style="margin-bottom: -20px;">Clique em cima do item para mais opções... </p>      
                          </div>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                    </div>
                  </div>
                  <div class="panel-body">
                      <ul class="list-group">
                        <div class=" table table-hover table-responsive">
                          <?php 
                            include_once "../classes/crudClass.php";
                            $cClass = new crudClass();
                            $cClass->listar('mesa','descricao');
                            $count=0;
                            if(0==mysqli_num_rows($cClass->getConsulta()))
                            {
                              ?>
                              <li class="list-group-item">
                                <center><h4 style="color:#EB2626">Nenhuma mesa para mostrar...</h4></center>
                              </li>
                              <?php
                            }
                            else
                            {
                              ?>
                              <table class="table table-hover table-condensed">
                                <thead>
                                  <tr class="filters">
                                      <th><input type="text" class="form-control" placeholder="Descrição" disabled></th>
                                  </tr>
                                </thead>
                              <?php
                              while($array_ = mysqli_fetch_array($cClass->getConsulta()))
                              {
                                $count++;
                                ?>
                                    <tr>
                                      <td style="cursor:hand"
                                      data-toggle="modal" 
                                      data-target="#modalCadastro"
                                      data-id="<?php echo $array_['id'];?>"
                                      data-descricao="<?php echo $array_['descricao'];?>"
                                      data-action="editar"
                                      >
                                        <small style="color:#080808;font-size: 110%"><?php echo $array_['descricao'];?></small>
                                      </td>
                                    <div class="pull-right action-buttons">
                                      <!-- clique do botão excluir -->
                                      <td><p><button class="btn btn-danger btn-sm" data-toggle="modal" 
                                        type="button" 
                                        data-target="#delete"
                                        data-id="<?php echo $array_['id'];?>"
                                        data-descricao="<?php echo $array_['descricao'];?>"
                                        data-action="excluir" rel="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span></button></p>
                                      </td>
                                    </div>                                  
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
</body>