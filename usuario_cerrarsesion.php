<?php require_once('Connections/conexionsystem.php'); ?>
<?php 
 $_SESSION['MM_Username'] = "";
    $_SESSION['MM_UserGroup'] = "";
	$_SESSION['MM_idUsuario'] = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Principal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="estilo/principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-image: url(imagenes/1920_1200_20091119011123237500.jpg);
	background-color: #666;
}
a:link {
	color: #333;
}
</style>
</head>

<body>

<div class="container">
  <div class="header"><div class="headerinterior"></div></div>
  <div class="subcontenedor">
                  <div class="sidebar1">
                  
                  <?php include("includes/catalogo.php"); ?><!-- end .sidebar1 --></div>
                  <div class="content">
                  <h1><!-- InstanceBeginEditable name="Titulo" -->Cerrando Sesi&oacute;n<!-- InstanceEndEditable --></h1>
                  <p><!-- InstanceBeginEditable name="Contenido" -->Muchas gracias por comprar en este sitio.<!-- InstanceEndEditable --><!-- end .content --></p>
    </div>
    <!-- end .subcontenedor -->
    </div>
  <div class="footer">
    <p>MercaSystem</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
