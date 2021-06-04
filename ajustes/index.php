<script type='text/javascript' src='../js/jquery-2.1.1.min.js'></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../js/bootstrap-toggle.min.js"></script>
<script src="../js/envia_dados.js" type="text/javascript"></script>
<script src="../js/waitingfor.js" type="text/javascript"></script>
<link rel="stylesheet" href="../css/bootstrap.css">
<link href="../css/bootstrap-toggle.min.css" rel="stylesheet"><!-- REFERENCIA AO CHECKBOX TOGGLE-->
<link rel="icon" type="image/png" href="../images/favicon.ico">
<?php include_once "../verificador/verificador.php"; ?>
<head>
	<title>FoodControl - Ajustes</title>
    <style type="text/css">
    	body{
        background-color: #690202;
      }
    </style>

    <script type="text/javascript">
        function salvaConfiguracoes()
        {
          pt=document.getElementById("chkPrevisaoTempo").checked;
          local=document.getElementById("inpCidade").value;
          em=document.getElementById("tipo_menu").value;
          printer=document.getElementById("inpImpressora").value;
          printer_cozinha=document.getElementById("inpImpressoraCozinha").value;
          printer_copa=document.getElementById("inpImpressoraCopa").value;
          razao_social=document.getElementById("inpRazaoSocial").value;
          CNPJ=document.getElementById("inpCNPJ").value;
          imprimir_cupom_obs=document.getElementById("chkImprimirCupomObs").checked
          modo_venda=document.getElementById("modo_venda").value;
          var queryString="previsao_tempo="+pt+"&local="+local+"&estilo_menu="+em+"&printer="+printer+"&printer_cozinha="+printer_cozinha+"&printer_copa="+printer_copa+"&razao_social="+razao_social;
          queryString+="&CNPJ="+CNPJ+"&imprimir_cupom_obs="+imprimir_cupom_obs+"&modo_venda="+modo_venda;
          buscaDados("statusSalvar",queryString,"../get/getAjustes.php?action=salvar","Não foi possível salvar as configurações",'../');
        }

    </script>
</head>
<body>
  <?php
    include_once('../classes/Ini.class.php');
    $config = new IniParser( '../config.ini' );
  ?>
<div class="container">
	<center><img class="img img-responsive" style="max-width:300px;margin-top:10px" src="../images/logo-foodcontrol.png"><hr></center>
  	<div class="row">
        <div id="bc1" class="btn-group btn-breadcrumb">
            <a href="../index.php" class="btn btn-warning"><div>Início</div></a>
            <a href="#" class="btn btn-default active"><div>Ajustes</div></a>
        </div>
        <button type="button" class="btn btn-success pull-right" onclick="location.reload()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Atualizar</button>
    </div><br>
	<div class="panel panel-primary">
		<div class="panel-heading">Ajustes da Tela Inicial</div>
  		<div class="panel-body">

        <div class="jumbotron">
          <div class="row">
            <div class="col-md-6">
              <h4>Previsão do tempo*</h4>
              <div class="col-md-4">
      		      <label class="checkbox-inline">
                  <input id="chkPrevisaoTempo" type="checkbox" data-toggle="toggle" data-on="Ativado" data-off="Desativado"  
                  <?php if($config->getValue('previsao_tempo_feed')) echo 'checked'; else echo ''; ?> />
                </label>
              </div>
              <div class="col-md-8">
                <input id="inpCidade" type="text" class="form-control" placeholder="Sua cidade" value="<?php echo $config->getValue('local'); ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="col-md-6">
                <h4>Estilo de Menu</h4>
                <select id="tipo_menu" class="form-control">
                  <option value="normal" <?php if($config->getValue('type')=='normal') echo 'selected';?> >Clássico</option>
                  <option value="metro" <?php if($config->getValue('type')=='metro') echo 'selected';?> >Metro</option>
                  <option value="normal_side" <?php if($config->getValue('type')=='normal_side') echo 'selected';?> >Barra Lateral</option>
                </select>
              </div>
            </div>
          </div>
          <br>
          <br><h5>*Disponível apenas no Estilo de menu 'Metro'</h5>
        </div>
        <div class="jumbotron">
          <div class="row">
            <div class="col-md-4">
              <h4>Nome da Impressora (Caixa):</h4>
              <input id="inpImpressora" type="text" class="form-control" placeholder="Nome da Impressora" value="<?php echo $config->getValue('printer'); ?>">
            </div>
            <div class="col-md-4">
              <h4>Nome da Impressora (Cozinha):</h4>
              <input id="inpImpressoraCozinha" type="text" class="form-control" placeholder="Nome da Impressora" value="<?php echo $config->getValue('printer_cozinha'); ?>">
            </div>
            <div class="col-md-4">
              <h4>Nome da Impressora (Copa):</h4>
              <input id="inpImpressoraCopa" type="text" class="form-control" placeholder="Nome da Impressora" value="<?php echo $config->getValue('printer_copa'); ?>">
            </div>
          </div>
          <div class="row">
              <div class="col-md-4">
                <h4>Razão social da Empresa:</h4>
                <input id="inpRazaoSocial" type="text" class="form-control" placeholder="Razão Social" value="<?php echo $config->getValue('razao_social'); ?>">
              </div>
              <div class="col-md-4">
                <h4>CNPJ da Empresa:</h4>
                <input id="inpCNPJ" type="text" class="form-control" placeholder="CNPJ" value="<?php echo $config->getValue('CNPJ'); ?>">
              </div>
              <div class="col-md-4">
                <h4>Imprimir obs. do pedido no cupom:</h4>
                <label class="checkbox-inline">
                  <input id="chkImprimirCupomObs" type="checkbox" data-toggle="toggle" data-on="Ativado" data-off="Desativado"  
                  <?php if($config->getValue('imprimir_cupom_obs')) echo 'checked'; else echo ''; ?> />
                </label>
              </div>
          </div>
        </div>
        <div class="jumbotron">
          <div class="row">
            <div class="col-md-6">
              <div class="col-md-6">
                <h4>Estilo de Venda</h4>
                <select id="modo_venda" class="form-control">
                  <option value="mesa" <?php if($config->getValue('modo_venda')=='mesa') echo 'selected';?> >Mesas</option>
                  <option value="pedido" <?php if($config->getValue('modo_venda')=='pedido') echo 'selected';?> >Pedidos</option>                  
                </select>
              </div>
            </div>
          </div>
        </div>

  		</div>
      <div class="panel-footer">
        <button class="btn btn-success btn-lg btn-block" type="button" onclick="salvaConfiguracoes();waitingDialog.show();setTimeout(function () {waitingDialog.hide();}, 3000);">Salvar configurações</button>
        <center><div id="statusSalvar"</div></center>
        <br>        
      </div>
	</div>         
  
  <div class="panel panel-primary">
    <div class="panel-heading">Informações da conexão com o Banco de Dados</div>
      <div class="panel-body">
        <div class="row">
          <div class="col-md-2">
            <h4>Nome do Servidor:</h4>
            <div class="col-md-6">
                <h4><span class="label label-danger"><?php echo $config->getValue('server');?></span></h4>
            </div>
          </div>
          <div class="col-md-2">
            <h4>Nome do Usuário:</h4>
            <div class="col-md-6">
                <h4><span class="label label-danger"><?php echo $config->getValue('usuario');?></span></h4>
            </div>
          </div>
          <div class="col-md-3">
            <h4>Nome do Banco de Dados:</h4>
            <div class="col-md-6">
                <h4><span class="label label-danger"><?php echo $config->getValue('banco');?></span></h4>
            </div>
          </div>
          <div class="col-md-3">
            <h4>Servidor (ip):</h4>
            <div class="col-md-6">
              <?php          
                $ip = getHostByName(getHostName());
              ?>
                <h4><span class="label label-danger"><?php echo $ip;?></span></h4>
            </div>
          </div>
          <div class="col-md-2">
            <h4>MAC:</h4>
            <div class="col-md-6">
              <?php          
                include_once '../classes/mac.php';
                $pegamac = new Mac;
                $mac=$pegamac->MacId();
              ?>
                <h4><span class="label label-danger"><?php echo $mac;?></span></h4>
            </div>
          </div>
        </div>
        <br>
      </div>
  </div>         
</div>


</body>