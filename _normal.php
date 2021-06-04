<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/waitingfor.js" type="text/javascript"></script>
<script src="js/envia_dados.js" type="text/javascript"></script>
<?php include_once "verificador.php"; ?>
<head>
    <title>FoodControl</title>
    <link rel="stylesheet" href="css/sidebarr.css">
    <link rel="stylesheet" href="css/progressbartiles.css">
   
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <style type="text/css">
      body{
        background-color: #690202;
      }

      p.credit {
        margin-top: -3%;
      }
    </style>
    <script type="text/javascript">
       
      function fazer_backup()
      {
        var urlData="action=backup";
        buscaDados("statusBackup",urlData,"get/getConfiguracoes.php?action=backup","Não foi possível fazer o backup",""); 
      }

      function download(filename, text) 
      {
        var pom = document.createElement('a');
        pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
        pom.setAttribute('download', filename);
        pom.click();
      }

      function logout()
      {
        buscaDados("statusLogout","","get/getUsuario.php?action=logout","","true");
      }

      function createNoty(message, type) {
        var html = '<div class="alert alert-' + type + ' alert-dismissable page-alert">';    
        html += '<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
        html += message;
        html += '</div>';    
        $(html).hide().prependTo('#noty-holder').slideDown();
    }

    function notificacao(mensagem)
    {
      createNoty(mensagem, 'danger');
      $('.page-alert .close').click(function(e) {
          e.preventDefault();
          $(this).closest('.page-alert').slideUp();
      });
    }

    </script>
    
</head>
<body>
  <div id="noty-holder"></div><!-- HERE IS WHERE THE NOTY WILL APPEAR-->
  <?php    
      include_once "classes/crudClass.php";
      $cClass=new crudClass();
      $dias=$cClass->verificaValidadeLicencaDias();
      if($dias<=10)
      { 
        if($dias==0)
        {
          ?>
            <script>notificacao('Sua licença vai expirar hoje!'); </script>
          <?php }
        else
        {?>
          <script>notificacao('Sua licença vai expirar em <?php echo $dias;?> dias!'); </script>
        <?php } 
      }
      $total_mesas=$cClass->count('mesa');
      $mesas_ocupadas=$cClass->countMesasOcupadas();
  ?>
      <div class="container">    
            <nav class="navbar navbar-default sidebar" role="navigation">
                <div class="container-fluid">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" style="margin-bottom:0px" href="#">Olá <?php echo $_SESSION['login'];?></a>
                    <span class="label label-danger"><a href="#" onclick="logout()" style="color:#fff">SAIR</a></span><br><br>
                    <div id="statusLogout"></div>
                  </div>
                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                      <li class="active"><a href="#"> Início<span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
                      <li class="dropdown"> <!-- MODOS -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Modos <span class="caret"></span><span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-align-justify"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                          <li><a href="auxiliar/"><span class="glyphicon glyphicon-cog" aria-hidden="true" style="margin-left:20%"></span> Auxiliar</a></li>
                          <li><a href="caixa/"><span class="glyphicon glyphicon-usd" aria-hidden="true" style="margin-left:20%"></span> Caixa</a></li>
                          <li><a href="cozinha/"><span class="glyphicon glyphicon-cutlery" aria-hidden="true" style="margin-left:20%"></span> Cozinha</a></li>
                          <li><a href="garcom/"><span class="glyphicon glyphicon-glass" aria-hidden="true" style="margin-left:20%"></span> Garçom</a></li>
                          <li><a href="tele/"><span class="glyphicon glyphicon-send" aria-hidden="true" style="margin-left:20%"></span> Tele-Entrega</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"> <!-- CADASTROS -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Cadastros <span class="caret"></span><span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-pencil"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                          <li><a href="cadastro/cardapio.php"><span class="glyphicon glyphicon-list-alt" aria-hidden="true" style="margin-left:20%"></span> Cardápio</a></li>
                          <li><a href="cadastro/cliente.php"><span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-left:20%"></span> Clientes</a></li>
                          <li><a href="cadastro/credor.php"><span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-left:20%"></span> Credor</a></li>
                          <li><a href="cadastro/divida.php"><span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-left:20%"></span> Dívida</a></li>
                          <li><a href="cadastro/estoque.php"><span class="glyphicon glyphicon-tag" aria-hidden="true" style="margin-left:20%"></span> Estoque</a></li>
                          <li><a href="cadastro/mesa.php"><span class="glyphicon glyphicon-unchecked" aria-hidden="true" style="margin-left:20%"></span> Mesas</a></li>
                          <li><a href="cadastro/usuario.php"><span class="glyphicon glyphicon-user" aria-hidden="true" style="margin-left:20%"></span> Usuários</a></li>
                        </ul>
                      </li>
                      <li> <!-- RELATÓRIOS -->
                        <a href="relatorio/"> Relatórios <span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-list-alt"></span></a>
                      </li>
                      <li class="dropdown"> <!-- CONFIGURAÇÕES -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Configurações <span class="caret"></span><span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
                        <ul class="dropdown-menu forAnimate" role="menu">
                          <li><a href="#" onclick="fazer_backup()"><span class="glyphicon glyphicon-hdd" aria-hidden="true" style="margin-left:20%"></span> Fazer Backup</a></li>
                          <div id="statusBackup"></div>
                          <li><a href="licenca.php"><span class="glyphicon glyphicon-flag" aria-hidden="true" style="margin-left:20%"></span> Licença</a></li>
                          <li><a href="ajustes/"><span class="glyphicon glyphicon-wrench" aria-hidden="true" style="margin-left:20%"></span> Ajustes</a></li>
                        </ul>
                      </li>
                      <li ><a href="http://www.evaldorc.com.br/logs/foodcontrol.php?versao=<?php echo $GLOBALS['versao'];?>"> Sobre <span style="font-size:16px;" class="pull-left hidden-xs showopacity glyphicon glyphicon-info-sign"></span></a></li>
                    </ul>
                  </div>
                </div>
            </nav>
            <center>
              <img class="img img-responsive" style="max-width:500px;margin-top:80px" src="images/logo-foodcontrol.png">
                <span class="label label-danger pull-right" style="margin-right:300px"><?php echo 'v. '.$GLOBALS['versao'];?></span>
              </img>
            </center>
            <div class="row" style="margin: 80 0 0 40">
              <div class="col-sm-3 col-md-offset-3">
                <div class="tile-progress tile-primary">
                  <div class="tile-header">
                    <h3>Mesas</h3>
                    <span>O quanto seu estabelecimento está lotado</span>
                  </div>
                  <div class="tile-progressbar">
                    <?php
                      try
                      {
                        $porcentagem_lotacao=number_format(($mesas_ocupadas*100)/($total_mesas == 0 ? 1 : $total_mesas),0);
                      }
                      catch(Exception $exx)
                      {
                        $porcentagem_lotacao='0';
                      }
                    ?>
                    <span data-fill="<?php echo $porcentagem_lotacao; ?>%" style="width: <?php echo $porcentagem_lotacao; ?>%;"></span>
                  </div>
                  <div class="tile-footer">
                    <h4>
                      <span class="pct-counter"><?php echo $porcentagem_lotacao; ?></span>% de ocupação
                    </h4>
                    <!--<span>***</span>-->
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                <?php
                  $campos = array('situacao' => 0 );
                  $total_pedidos=$cClass->count2('pedido',$campos);
                  $pedidos_esperando_itens=$cClass->countPedidosEsperandoItens();
                ?>
                <div class="tile-progress tile-red">
                  <div class="tile-header">
                    <h3>Pedidos</h3>
                    <span>Qual a porcentagem de pedidos aguardando por itens</span>
                  </div>
                  <div class="tile-progressbar">
                    <?php 
                    try
                    {
                      $porcentagem_pedidos=number_format(($pedidos_esperando_itens*100)/($total_pedidos == 0 ? 1 : $total_pedidos),0);  
                    }
                    catch(Exception $ex)
                    {
                      $porcentagem_pedidos='0';
                    } ?>
                    <span data-fill="<?php echo $porcentagem_pedidos; ?>%" style="width:<?php echo $porcentagem_pedidos; ?>%"></span>
                  </div>
                  <div class="tile-footer">
                    <h4>
                      <span class="pct-counter"><?php echo $porcentagem_pedidos; ?></span>% dos pedidos
                    </h4>
                    <!--<span>***</span>-->
                  </div>
                </div>
              </div>
                <!--
                <div class="col-sm-3">
                  <div class="tile-progress tile-blue">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="78%" style="width: 78%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">78</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="tile-progress tile-aqua">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="22%" style="width: 22%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">22</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
                    </div>
              <div class="row" style="margin: 0 10 0 100">
                  <div class="col-sm-3">
                  <div class="tile-progress tile-green">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="94%" style="width: 94%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">94</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="tile-progress tile-cyan">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="45.9%" style="width: 45.9%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">45.9</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="tile-progress tile-purple">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="27%" style="width: 27%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">27</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="tile-progress tile-pink">
                    <div class="tile-header">
                      <h3>Visitors</h3>
                      <span>so far in our blog, and our website.</span>
                    </div>
                    <div class="tile-progressbar">
                      <span data-fill="3" style="width: 3%;"></span>
                    </div>
                    <div class="tile-footer">
                      <h4>
                        <span class="pct-counter">3</span>% increase
                      </h4>
                      <span>so far in our blog and our website</span>
                    </div>
                  </div>
                </div>
              </div>-->
            </div>
      </div>
<center>
  <p class="credit" style="color:#fff">Copyright © 2015 - Todos os direitos reservados</p>
</center>
</body>