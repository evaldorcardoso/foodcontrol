<script type='text/javascript' src='js/jquery-2.1.1.min.js'></script>
<link rel="stylesheet" href="css/bootstrap.css"><!--REFERENCIA Á PÁGINA CONTENDO O ESTILO CSS -->
<script src="js/bootstrap.js" type="text/javascript"></script>
<script src="js/waitingfor.js" type="text/javascript"></script>
<script src="js/envia_dados.js" type="text/javascript"></script>
<?php include_once "verificador.php"; ?>
<head>
	<title>FoodControl</title>
  <link rel="stylesheet" href="css/progressbartiles.css">
    <style type="text/css">
    	body{
        background-color: #690202;
      }

      p.credit {
        margin-top: -3%;
      }

      body,html{
    height: 100%;
  }

  nav.sidebar, .main{
    -webkit-transition: margin 200ms ease-out;
      -moz-transition: margin 200ms ease-out;
      -o-transition: margin 200ms ease-out;
      transition: margin 200ms ease-out;
  }

  .main{
    padding: 10px 10px 0 10px;
  }

 @media (min-width: 765px) {

    .main{
      position: absolute;
      width: calc(100% - 40px); 
      margin-left: 40px;
      float: right;
    }

    nav.sidebar:hover + .main{
      margin-left: 200px;
    }

    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }

    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }
    
    nav.sidebar a{
      padding-right: 13px;
    }

    nav.sidebar .navbar-nav > li:first-child{
      border-top: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav > li{
      border-bottom: 1px #e5e5e5 solid;
    }

    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      margin-bottom: 0px;
    }

    nav.sidebar li {
      width: 100%;
    }

    nav.sidebar:hover{
      margin-left: 0px;
    }

    .forAnimate{
      opacity: 0;
    }
  }
   
  @media (min-width: 1380px) {

    .main{
      width: calc(100% - 200px);
      margin-left: 200px;
    }

    nav.sidebar{
      margin-left: 0px;
      float: left;
    }

    nav.sidebar .forAnimate{
      opacity: 1;
    }
  }

  nav.sidebar .navbar-nav .open .dropdown-menu>li>a:hover, nav.sidebar .navbar-nav .open .dropdown-menu>li>a:focus {
    color: #CCC;
    background-color: transparent;
  }

  nav:hover .forAnimate{
    opacity: 1;
  }
  section{
    padding-left: 15px;
  }
  
#noty-holder{    
    width: 100%;    
    top: 0;
    font-weight: bold;    
    z-index: 1031; /* Max Z-Index in Fixed Nav Menu is 1030*/
    text-align: center;
    position: fixed;
}

.alert{
    margin-bottom: 2px;
    border-radius: 0px;
}

#main{
    min-height:900px;
}


.starter-template {
  padding: 40px 15px;
  text-align: center;
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
      include_once('classes/Ini.class.php');
      $config = new IniParser( 'config.ini' );
      $total_mesas=$cClass->count('mesa');
      $mesas_ocupadas=$cClass->countMesasOcupadas();
  ?>  
    <nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
    </div>
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Início<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li class="dropdown"> <!-- MODOS -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Modos <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-align-justify"></span></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li><a href="auxiliar/"><span class="glyphicon glyphicon-cog" aria-hidden="true" style="margin-left:20%"></span> Auxiliar</a></li>
            <li><a href="caixa/"><span class="glyphicon glyphicon-usd" aria-hidden="true" style="margin-left:20%"></span> Caixa</a></li>
            <li><a href="cozinha/"><span class="glyphicon glyphicon-cutlery" aria-hidden="true" style="margin-left:20%"></span> Cozinha</a></li>
            <li><a href="garcom/"><span class="glyphicon glyphicon-glass" aria-hidden="true" style="margin-left:20%"></span> Garçom</a></li>
            <li><a href="tele/"><span class="glyphicon glyphicon-send" aria-hidden="true" style="margin-left:20%"></span> Tele-Entrega</a></li>
          </ul>
        </li>
        <li class="dropdown"> <!-- CADASTROS -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Cadastros <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-pencil"></span></a>  
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
          <a href="relatorio/"> Relatórios <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-list-alt"></span></a>
        </li>
        <li class="dropdown"> <!-- CONFIGURAÇÕES -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Configurações <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
          <ul class="dropdown-menu forAnimate" role="menu">
            <li><a href="#" onclick="fazer_backup()"><span class="glyphicon glyphicon-hdd" aria-hidden="true" style="margin-left:20%"></span> Fazer Backup</a></li>
              <div id="statusBackup"></div>
            <li><a href="licenca.php"><span class="glyphicon glyphicon-flag" aria-hidden="true" style="margin-left:20%"></span> Licença</a></li>
            <li><a href="ajustes/"><span class="glyphicon glyphicon-wrench" aria-hidden="true" style="margin-left:20%"></span> Ajustes</a></li>
          </ul>
        </li>
        <li ><a href="http://www.evaldorc.com.br/logs/foodcontrol.php?versao=<?php echo $GLOBALS['versao'];?>"> Sobre <span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-info-sign"></span></a></li>
        <li style="margin-top:40%" ><center> Olá <?php echo $_SESSION['login'];?><br><a href="#" onclick="logout()"> Sair</a></center></li>                
      </ul>
    </div>
    </div>
    </nav>

<center>
  <img class="img img-responsive" style="max-width:500px;" src="images/logo-foodcontrol.png">
  </img><br><span class="label label-danger"><?php echo 'v. '.$GLOBALS['versao'];?></span>
</center>
<div class="row" style="margin: 80 0 0 40">
<?php if($config->getValue('modo_venda')=='mesa'){ ?>
  <div class="col-sm-3 col-md-offset-3">
    <div class="tile-progress tile-primary">
      <div class="tile-header">
        <h3>Mesas</h3>
          <span>O quanto seu estabelecimento está lotado</span>
      </div>
      <div class="tile-progressbar">
        <?php try
          {
            $porcentagem_lotacao=number_format(($mesas_ocupadas*100)/($total_mesas == 0 ? 1 : $total_mesas),0);
          }
          catch(Exception $exx)
          {
            $porcentagem_lotacao='0';
          } ?>
          <span data-fill="<?php echo $porcentagem_lotacao; ?>%" style="width: <?php echo $porcentagem_lotacao; ?>%;"></span>
      </div>
      <div class="tile-footer">
        <h4><span class="pct-counter"><?php echo $porcentagem_lotacao; ?></span>% de ocupação</h4>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-sm-3 <?php if($config->getValue('modo_venda')=='pedido'){ echo 'col-md-offset-4';} ?>">
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
        <h4><span class="pct-counter"><?php echo $porcentagem_pedidos; ?></span>% dos pedidos</h4>
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
  <p class="credit" style="color:#fff" onclick="notificacao('fsdfsdf');">Copyright © 2015 - Todos os direitos reservados</p>
</center>

</body>