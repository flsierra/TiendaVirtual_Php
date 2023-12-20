<?php require_once('Connections/conexionsystem.php'); ?>

<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$varUsuario_DatosCarrito = "0";
if (isset($_SESSION["MM_idUsuario"])) {
  $varUsuario_DatosCarrito = $_SESSION["MM_idUsuario"];
}
mysql_select_db($database_conexionsystem, $conexionsystem);
$query_DatosCarrito = sprintf("SELECT * FROM carrito WHERE carrito.idUsuario =%s AND carrito.intTransaccionEfectuada = 0", GetSQLValueString($varUsuario_DatosCarrito, "int"));
$DatosCarrito = mysql_query($query_DatosCarrito, $conexionsystem) or die(mysql_error());
$row_DatosCarrito = mysql_fetch_assoc($DatosCarrito);
$totalRows_DatosCarrito = mysql_num_rows($DatosCarrito);
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
                  <h1><!-- InstanceBeginEditable name="Titulo" -->Carrito de la compra<!-- InstanceEndEditable --></h1>
                  <p><!-- InstanceBeginEditable name="Contenido" --><table width="100%" border="1">
  <tr>
    <td>Producto</td>
    <td>Unidades</td>
    <td>Precio</td>
    <td>Acciones</td>
  </tr>
  <?php $preciototal = 0; ?>
  <?php do { ?>
    <tr>
      <td><?php echo ObtenerNombreProducto($row_DatosCarrito['idProducto']); ?></td>
      <td><?php echo $row_DatosCarrito['intCantidad']; ?></td>
      <td><?php echo ObtenerPrecioProducto($row_DatosCarrito['idProducto']); ?></td>
      <td><a href="carrito_delete.php?recordID=<?php echo $row_DatosCarrito['intContador']; ?>">Eliminar</a></td>
    </tr>
    <?php  $preciototal= $preciototal +  ObtenerPrecioProducto($row_DatosCarrito['idProducto'])?>
    <?php } while ($row_DatosCarrito = mysql_fetch_assoc($DatosCarrito)); ?>

<tr>
  
  <td>&nbsp;</td>
      <td align="right">SubTotal:</td>
      <td> <?php echo $preciototal ; ?>Pesos</td>
      <td>&nbsp;</td>
  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">IVA</td>
                    <td><?php echo ObtenerIVA();?>%</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">Valor del IVA</td>
                    <td><?php 
					$multiplicador= ObtenerIVA()/100;
					$valordelIVA= $preciototal * $multiplicador;
					echo $valordelIVA;?> Pesos</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="right">TOTAL CON IVA</td>
                    <td><?php 
					$multiplicador = (100+ObtenerIVA())/100;
					$valorconIVA=$preciototal * $multiplicador;
					echo $valorconIVA;?>Pesos</td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
<!-- InstanceEndEditable --><!-- end .content --></p>
    </div>
    <!-- end .subcontenedor -->
    </div>
  <div class="footer">
    <p>MercaSystem</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($DatosCarrito);
?>
