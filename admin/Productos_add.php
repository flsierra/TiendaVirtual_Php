<?php require_once('../Connections/conexionsystem.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO productos (strNombre, strSEO, dblPrecio, intEstado, intCategoria, strImagen) VALUES (%s, %s, %s, %s, %s,%s)",
                       GetSQLValueString($_POST['strNombre'], "text"),
                       GetSQLValueString($_POST['strSEO'], "text"),
                       GetSQLValueString($_POST['dblPrecio'], "text"),
                       GetSQLValueString($_POST['intEstado'], "int"),
                       GetSQLValueString($_POST['intCategoria'], "int"),
					                          GetSQLValueString($_POST['strImagen'], "text"));

  mysql_select_db($database_conexionsystem, $conexionsystem);
  $Result1 = mysql_query($insertSQL, $conexionsystem) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_AdminData = 10;
$pageNum_AdminData = 0;
if (isset($_GET['pageNum_AdminData'])) {
  $pageNum_AdminData = $_GET['pageNum_AdminData'];
}
$startRow_AdminData = $pageNum_AdminData * $maxRows_AdminData;

mysql_select_db($database_conexionsystem, $conexionsystem);
$query_AdminData = "SELECT * FROM productos ORDER BY productos.strNombre ASC";
$query_limit_AdminData = sprintf("%s LIMIT %d, %d", $query_AdminData, $startRow_AdminData, $maxRows_AdminData);
$AdminData = mysql_query($query_limit_AdminData, $conexionsystem) or die(mysql_error());
$row_AdminData = mysql_fetch_assoc($AdminData);

if (isset($_GET['totalRows_AdminData'])) {
  $totalRows_AdminData = $_GET['totalRows_AdminData'];
} else {
  $all_AdminData = mysql_query($query_AdminData);
  $totalRows_AdminData = mysql_num_rows($all_AdminData);
}
$totalPages_AdminData = ceil($totalRows_AdminData/$maxRows_AdminData)-1;

mysql_select_db($database_conexionsystem, $conexionsystem);
$query_ConsultaCategorias = "SELECT * FROM categoria ORDER BY categoria.strDescripcion ASC";
$ConsultaCategorias = mysql_query($query_ConsultaCategorias, $conexionsystem) or die(mysql_error());
$row_ConsultaCategorias = mysql_fetch_assoc($ConsultaCategorias);
$totalRows_ConsultaCategorias = mysql_num_rows($ConsultaCategorias);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Bas-Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administracion Principal Merca System</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
<style type="text/css">
<!--
body {
	margin: 0;
	padding: 0;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 16px;
	color: #0F0;
	background-image: url(../imagenes/1920_1200_20091119011123237500.png);
	background-repeat: repeat-x;
	background-color: #FFF;
}

/* ~~ Selectores de elemento/etiqueta ~~ */
ul, ol, dl { /* Debido a las diferencias existentes entre los navegadores, es recomendable no añadir relleno ni márgenes en las listas. Para lograr coherencia, puede especificar las cantidades deseadas aquí o en los elementos de lista (LI, DT, DD) que contienen. Recuerde que lo que haga aquí se aplicará en cascada en la lista .nav, a no ser que escriba un selector más específico. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* la eliminación del margen superior resuelve un problema que origina que los márgenes escapen de la etiqueta div contenedora. El margen inferior restante lo mantendrá separado de los elementos de que le sigan. */
	padding-right: 15px;
	padding-left: 15px; /* la adición de relleno a los lados del elemento dentro de las divs, en lugar de en las divs propiamente dichas, elimina todas las matemáticas de modelo de cuadro. Una div anidada con . */
}
a img { /* este selector elimina el borde azul predeterminado que se muestra en algunos navegadores alrededor de una imagen cuando está rodeada por un vínculo */
	border: none;
}

/* ~~ La aplicación de estilo a los vínculos del sitio debe permanecer en este orden (incluido el grupo de selectores que crea el efecto hover -paso por encima-). ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* a no ser que aplique estilos a los vínculos para que tengan un aspecto muy exclusivo, es recomendable proporcionar subrayados para facilitar una identificación visual rápida */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* este grupo de selectores proporcionará a un usuario que navegue mediante el teclado la misma experiencia de hover (paso por encima) que experimenta un usuario que emplea un ratón. */
	text-decoration: none;
}

/* ~~ este contenedor de anchura fija rodea a las demás divs ~~ */
.container {
	width: 960px;
	background-color: #FFF;
	margin: 0 auto; /* el valor automático de los lados, unido a la anchura, centra el diseño */
}

/* ~~ no se asigna una anchura al encabezado. Se extenderá por toda la anchura del diseño. Contiene un marcador de posición de imagen que debe sustituirse por su propio logotipo vinculado ~~ */
.header {
	background-color: #ADB96E;
}

/* ~~ Estas son las columnas para el diseño. ~~ 

1) El relleno sólo se sitúa en la parte superior y/o inferior de las divs. Los elementos situados dentro de estas divs tienen relleno a los lados. Esto le ahorra las "matemáticas de modelo de cuadro". Recuerde que si añade relleno o borde lateral a la div propiamente dicha, éste se añadirá a la anchura que defina para crear la anchura *total*. También puede optar por eliminar el relleno del elemento en la div y colocar una segunda div dentro de ésta sin anchura y el relleno necesario para el diseño deseado. También puede optar por eliminar el relleno del elemento en la div y colocar una segunda div dentro de ésta sin anchura y el relleno necesario para el diseño deseado.

2) No se asigna margen a las columnas, ya que todas ellas son flotantes. Si es preciso añadir un margen, evite colocarlo en el lado hacia el que se produce la flotación (por ejemplo: un margen derecho en una div configurada para flotar hacia la derecha). En muchas ocasiones, puede usarse relleno como alternativa. En el caso de divs para las que deba incumplirse esta regla, deberá añadir una declaración "display:inline" a la regla de la div para evitar un error que provoca que algunas versiones de Internet Explorer dupliquen el margen.

3) Dado que las clases se pueden usar varias veces en un documento (y que también se pueden aplicar varias clases a un elemento), se ha asignado a las columnas nombres de clases en lugar de ID. Por ejemplo, dos divs de barra lateral podrían apilarse si fuera necesario. Si lo prefiere, éstas pueden cambiarse a ID fácilmente, siempre y cuando las utilice una sola vez por documento.

4) Si prefiere que la navegación esté a la derecha en lugar de a la izquierda, simplemente haga que estas columnas floten en dirección opuesta (todas a la derecha en lugar de todas a la izquierda) y éstas se representarán en orden inverso. No es necesario mover las divs por el código fuente HTML.

*/
.sidebar1 {
	float: left;
	width: 180px;
	background-color: #EADCAE;
	padding-bottom: 10px;
}
.content {

	padding: 10px 0;
	width: 780px;
	float: left;
}

/* ~~ Este selector agrupado da espacio a las listas del área de .content ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* este relleno reproduce en espejo el relleno derecho de la regla de encabezados y de párrafo incluida más arriba. El relleno se ha colocado en la parte inferior para que el espacio existente entre otros elementos de la lista y a la izquierda cree la sangría. Estos pueden ajustarse como se desee. */
}

/* ~~ Los estilos de lista de navegación (pueden eliminarse si opta por usar un menú desplegable predefinido como el de Spry) ~~ */
ul.nav {
	list-style: none; /* esto elimina el marcador de lista */
	border-top: 1px solid #666; /* esto crea el borde superior de los vínculos (los demás se sitúan usando un borde inferior en el LI) */
	margin-bottom: 15px; /* esto crea el espacio entre la navegación en el contenido situado debajo */
}
ul.nav li {
	border-bottom: 1px solid #666; /* esto crea la separación de los botones */
}
ul.nav a, ul.nav a:visited { /* al agrupar estos selectores, se asegurará de que los vínculos mantengan el aspecto de botón incluso después de haber sido visitados */
	padding: 5px 5px 5px 15px;
	display: block; /* esto asigna propiedades de bloque al vínculo, lo que provoca que llene todo el LI que lo contiene. Esto provoca que toda el área reaccione a un clic de ratón. */
	width: 160px;  /*esta anchura hace que se pueda hacer clic en todo el botón para IE6. Puede eliminarse si no es necesario proporcionar compatibilidad con IE6. Calcule la anchura adecuada restando el relleno de este vínculo de la anchura del contenedor de barra lateral. */
	text-decoration: none;
	background-color: #C6D580;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* esto cambia el color de fondo y del texto tanto para usuarios que naveguen con ratón como para los que lo hagan con teclado */
	background-color: #ADB96E;
	color: #FFF;
}

/* ~~ El pie de página ~~ */
.footer {
	padding: 10px 0;
	background-color: #CCC49F;
	position: relative;/* esto da a IE6 hasLayout para borrar correctamente */
	clear: both; /* esta propiedad de borrado fuerza a .container a conocer dónde terminan las columnas y a contenerlas */
}

/* ~~ clases float/clear varias ~~ */
.fltrt {  /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* esta clase puede situarse en una <br /> o div vacía como elemento final tras la última div flotante (dentro de #container) si #footer se elimina o se saca fuera de #container */
	clear:both;
	height:0;
	font-size: 1px;
	line-height: 0px;
}
.tablaprincipal{
	text-transform: uppercase;
	color: #FFF;
	background-color: #0F0;
}
.brillo:hover{
	background-color: #FF0;
}
body,td,th {
	color: #333;
}
	


-->
</style></head>

<body>
<img src="../imagenes/green-it-banner.png" width="1418" height="160" alt="Administracion" />
<div class="container">
  <div class="header"> 
    <!-- end .header --></div>
  <div class="sidebar1">
   <?php include("../includes/cabeceraadmin.php");
   ?>
    
    <!-- end .sidebar1 --></div>
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
  <script>
  function subirimagen()
{
	self.name = 'opener';
	remote =open('gestionimagen.php', 'remote',
'width=400,heigh=150,location=no,scrollbars=yes,mnubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes')
	remote.focus();
}
  </script>
  <h1>A&ntilde;adir Producto</h1>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Nombre:</td>
        <td><span id="sprytextfield1">
          <input type="text" name="strNombre" value="" size="32" />
          <span class="textfieldRequiredMsg">Necesario.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">SEO:</td>
        <td><span id="sprytextfield2">
          <input type="text" name="strSEO" value="" size="32" />
          <span class="textfieldRequiredMsg">Necesario.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Precio:</td>
        <td><span id="sprytextfield3">
          <input type="text" name="dblPrecio" value="" size="32" />
          <span class="textfieldRequiredMsg">Necesario.</span></span></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Imagen:
          <label for="strImagen"></label></td>
        <td><input type="text" name="strImagen" id="strImagen" />
          <input type="button" name="button" id="button" value="Subir Imagen" onclick="javascpript:subirimagen();"/></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Estado:</td>
        <td><select name="intEstado">
          <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>Activo</option>
          <option value="0" <?php if (!(strcmp(0, ""))) {echo "SELECTED";} ?>>Inactivo</option>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Categoria:</td>
        <td><label for="intCategoria"></label>
          <label for="intCategoria"></label>
          <label for="intCategoria"></label>
          <select name="intCategoria" id="intCategoria">
            <?php
do {  
?>
            <option value="<?php echo $row_ConsultaCategorias['idCategoria']?>"><?php echo $row_ConsultaCategorias['strDescripcion']?></option>
            <?php
} while ($row_ConsultaCategorias = mysql_fetch_assoc($ConsultaCategorias));
  $rows = mysql_num_rows($ConsultaCategorias);
  if($rows > 0) {
      mysql_data_seek($ConsultaCategorias, 0);
	  $row_ConsultaCategorias = mysql_fetch_assoc($ConsultaCategorias);
  }
?>
          </select></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" bgcolor="#D6D6D6">&nbsp;</td>
        <td><input type="submit" value="Insertar Producto" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
<p></p>
  
  <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
  </script>
  <!-- InstanceEndEditable -->
   
    <!-- end .content --></div>
  <div class="footer">
    <p>Administracion Merca System</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($AdminData);

mysql_free_result($ConsultaCategorias);
?>
