<?php
session_start();
if(($_SERVER['HTTP_HOST']!='localhost')&&($_SERVER['HTTP_HOST']!='evaldorc.com.br'))
{
  session_unset(); // Eliminar todas as variáveis da sessão
  session_destroy(); // Destruir a sessão
  ?>
  <center><img src="images/large-facebook.gif"/><center>
    <script> 
      setTimeout(function () { location.href="../login.php"; });
    </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
<?php
}
else
{
date_default_timezone_set('America/Sao_Paulo');
include_once('../classes/crudClass.php');
$cClass=new crudClass();
if(! $cClass->verificaValidadeLicenca())
{
    ?>
    <center><img src="../images/large-facebook.gif"/><center>
    <script> 
    	setTimeout(function () { location.href="../licenca.php"; });
    </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
    <?php
}
else
{ 
	if(isset($_SESSION['login']))
    {
        $campos = array('login' => $_SESSION['login']);       
        $cClass->pesquisaTabela('usuario',$campos);
        if(mysqli_num_rows($cClass->getconsulta())==0)
        {
          ?>
          <center><img src="../images/large-facebook.gif"/><center>
          <script> 
            setTimeout(function () { location.href="../login.php"; });
          </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
          <?php
        }
        //verificação dos níveis dos usuarios
        else
        {
          switch ($_SESSION['nivel']) {
            case '1':
              if(strpos($_SERVER['SCRIPT_NAME'],'garcom')==false)
              {
                ?>
                <center><img src="../images/large-facebook.gif"/><center>
                <script> setTimeout(function () { location.href="../index.php"; });</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
                <?php
              }
              break;
            case '2':
              if((strpos($_SERVER['SCRIPT_NAME'],'auxiliar')==false)&&(strpos($_SERVER['SCRIPT_NAME'],'cozinha')==false))
              {
                ?>
                <center><img src="../images/large-facebook.gif"/><center>
                <script> setTimeout(function () { location.href="../index.php"; });</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
                <?php
              }
              break;
            case '3':
              if(strpos($_SERVER['SCRIPT_NAME'],'caixa')==false)
              {
                ?>
                <center><img src="../images/large-facebook.gif"/><center>
                <script> setTimeout(function () { location.href="../index.php"; });</script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
                <?php
              }
              break;
            default:
              # code...
              break;
          }
        }
    }
    else
    {
    	?>
          <center><img src="../images/large-facebook.gif"/><center>
          <script> 
            setTimeout(function () { location.href="../login.php"; });
          </script><!-- SCRIPT PARA REDIRECIONAR AUTOMATICAMENTE PARA OUTRA PÁGINA  -->
          <?php
    }
}
}
?>