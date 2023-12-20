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

mysql_select_db($database_conexionsystem, $conexionsystem);
$query_Recordset1 = "SELECT * FROM categoria ORDER BY categoria.strDescripcion";
$Recordset1 = mysql_query($query_Recordset1, $conexionsystem) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><br>
<?php do { ?>
  <a href="categoria_ver.php?cat=<?php echo $row_Recordset1['idCategoria']; ?>"><?php echo $row_Recordset1['strDescripcion']; ?></a><br><br>
  <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
<p>
  <?php
mysql_free_result($Recordset1);
?>
    
 

<br />
  <a href="carrito_lista.php">Carrito</a><br /> <a href="usuario_modificar.php" > Modificar</a><br />
  <a href="usuario_cerrarsesion.php">Salir</a>
<?php
if ((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !=""))
{
  echo "Hola ";
  echo ObtenerNombreUsuario ($_SESSION['MM_idUsuario']);
?>
<br />
  <a href="carrito_lista.php">Carrito</a><br /> <a href="usuario_modificar.php" > Modificar</a><br />
  <a href="usuario_cerrarsesion.php">Salir</a>
<?php

}
else
  {?><br />
  <a href="alta_usuario.php">Registrarte</a></p>
<p><a href="acceso.php">Acceder</a></p>
<p>
  <?php } ?>


