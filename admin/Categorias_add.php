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
  $insertSQL = sprintf("INSERT INTO categoria (strDescripcion) VALUES (%s)",
                       GetSQLValueString($_POST['strDescripcion'], "text"));

  mysql_select_db($database_conexionsystem, $conexionsystem);
  $Result1 = mysql_query($insertSQL, $conexionsystem) or die(mysql_error());

  $insertGoTo = "Categorias_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Bas-Admin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administracion Principal Merca System</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
ul, ol, dl { /* Debido a las diferencias existentes entre los navegadores, es recomendable no a�adir relleno ni m�rgenes en las listas. Para lograr coherencia, puede especificar las cantidades deseadas aqu� o en los elementos de lista (LI, DT, DD) que contienen. Recuerde que lo que haga aqu� se aplicar� en cascada en la lista .nav, a no ser que escriba un selector m�s espec�fico. */
	padding: 0;
	margin: 0;
}
h1, h2, h3, h4, h5, h6, p {
	margin-top: 0;	 /* la eliminaci�n del margen superior resuelve un problema que origina que los m�rgenes escapen de la etiqueta div contenedora. El margen inferior restante lo mantendr� separado de los elementos de que le sigan. */
	padding-right: 15px;
	padding-left: 15px; /* la adici�n de relleno a los lados del elemento dentro de las divs, en lugar de en las divs propiamente dichas, elimina todas las matem�ticas de modelo de cuadro. Una div anidada con . */
}
a img { /* este selector elimina el borde azul predeterminado que se muestra en algunos navegadores alrededor de una imagen cuando est� rodeada por un v�nculo */
	border: none;
}

/* ~~ La aplicaci�n de estilo a los v�nculos del sitio debe permanecer en este orden (incluido el grupo de selectores que crea el efecto hover -paso por encima-). ~~ */
a:link {
	color: #42413C;
	text-decoration: underline; /* a no ser que aplique estilos a los v�nculos para que tengan un aspecto muy exclusivo, es recomendable proporcionar subrayados para facilitar una identificaci�n visual r�pida */
}
a:visited {
	color: #6E6C64;
	text-decoration: underline;
}
a:hover, a:active, a:focus { /* este grupo de selectores proporcionar� a un usuario que navegue mediante el teclado la misma experiencia de hover (paso por encima) que experimenta un usuario que emplea un rat�n. */
	text-decoration: none;
}

/* ~~ este contenedor de anchura fija rodea a las dem�s divs ~~ */
.container {
	width: 960px;
	background-color: #FFF;
	margin: 0 auto; /* el valor autom�tico de los lados, unido a la anchura, centra el dise�o */
}

/* ~~ no se asigna una anchura al encabezado. Se extender� por toda la anchura del dise�o. Contiene un marcador de posici�n de imagen que debe sustituirse por su propio logotipo vinculado ~~ */
.header {
	background-color: #ADB96E;
}

/* ~~ Estas son las columnas para el dise�o. ~~ 

1) El relleno s�lo se sit�a en la parte superior y/o inferior de las divs. Los elementos situados dentro de estas divs tienen relleno a los lados. Esto le ahorra las "matem�ticas de modelo de cuadro". Recuerde que si a�ade relleno o borde lateral a la div propiamente dicha, �ste se a�adir� a la anchura que defina para crear la anchura *total*. Tambi�n puede optar por eliminar el relleno del elemento en la div y colocar una segunda div dentro de �sta sin anchura y el relleno necesario para el dise�o deseado. Tambi�n puede optar por eliminar el relleno del elemento en la div y colocar una segunda div dentro de �sta sin anchura y el relleno necesario para el dise�o deseado.

2) No se asigna margen a las columnas, ya que todas ellas son flotantes. Si es preciso a�adir un margen, evite colocarlo en el lado hacia el que se produce la flotaci�n (por ejemplo: un margen derecho en una div configurada para flotar hacia la derecha). En muchas ocasiones, puede usarse relleno como alternativa. En el caso de divs para las que deba incumplirse esta regla, deber� a�adir una declaraci�n "display:inline" a la regla de la div para evitar un error que provoca que algunas versiones de Internet Explorer dupliquen el margen.

3) Dado que las clases se pueden usar varias veces en un documento (y que tambi�n se pueden aplicar varias clases a un elemento), se ha asignado a las columnas nombres de clases en lugar de ID. Por ejemplo, dos divs de barra lateral podr�an apilarse si fuera necesario. Si lo prefiere, �stas pueden cambiarse a ID f�cilmente, siempre y cuando las utilice una sola vez por documento.

4) Si prefiere que la navegaci�n est� a la derecha en lugar de a la izquierda, simplemente haga que estas columnas floten en direcci�n opuesta (todas a la derecha en lugar de todas a la izquierda) y �stas se representar�n en orden inverso. No es necesario mover las divs por el c�digo fuente HTML.

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

/* ~~ Este selector agrupado da espacio a las listas del �rea de .content ~~ */
.content ul, .content ol { 
	padding: 0 15px 15px 40px; /* este relleno reproduce en espejo el relleno derecho de la regla de encabezados y de p�rrafo incluida m�s arriba. El relleno se ha colocado en la parte inferior para que el espacio existente entre otros elementos de la lista y a la izquierda cree la sangr�a. Estos pueden ajustarse como se desee. */
}

/* ~~ Los estilos de lista de navegaci�n (pueden eliminarse si opta por usar un men� desplegable predefinido como el de Spry) ~~ */
ul.nav {
	list-style: none; /* esto elimina el marcador de lista */
	border-top: 1px solid #666; /* esto crea el borde superior de los v�nculos (los dem�s se sit�an usando un borde inferior en el LI) */
	margin-bottom: 15px; /* esto crea el espacio entre la navegaci�n en el contenido situado debajo */
}
ul.nav li {
	border-bottom: 1px solid #666; /* esto crea la separaci�n de los botones */
}
ul.nav a, ul.nav a:visited { /* al agrupar estos selectores, se asegurar� de que los v�nculos mantengan el aspecto de bot�n incluso despu�s de haber sido visitados */
	padding: 5px 5px 5px 15px;
	display: block; /* esto asigna propiedades de bloque al v�nculo, lo que provoca que llene todo el LI que lo contiene. Esto provoca que toda el �rea reaccione a un clic de rat�n. */
	width: 160px;  /*esta anchura hace que se pueda hacer clic en todo el bot�n para IE6. Puede eliminarse si no es necesario proporcionar compatibilidad con IE6. Calcule la anchura adecuada restando el relleno de este v�nculo de la anchura del contenedor de barra lateral. */
	text-decoration: none;
	background-color: #C6D580;
}
ul.nav a:hover, ul.nav a:active, ul.nav a:focus { /* esto cambia el color de fondo y del texto tanto para usuarios que naveguen con rat�n como para los que lo hagan con teclado */
	background-color: #ADB96E;
	color: #FFF;
}

/* ~~ El pie de p�gina ~~ */
.footer {
	padding: 10px 0;
	background-color: #CCC49F;
	position: relative;/* esto da a IE6 hasLayout para borrar correctamente */
	clear: both; /* esta propiedad de borrado fuerza a .container a conocer d�nde terminan las columnas y a contenerlas */
}

/* ~~ clases float/clear varias ~~ */
.fltrt {  /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la p�gina. El elemento flotante debe preceder al elemento junto al que debe aparecer en la p�gina. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la p�gina. El elemento flotante debe preceder al elemento junto al que debe aparecer en la p�gina. */
	float: left;
	margin-right: 8px;
}
.clearfloat { /* esta clase puede situarse en una <br /> o div vac�a como elemento final tras la �ltima div flotante (dentro de #container) si #footer se elimina o se saca fuera de #container */
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
  <h1>A&ntilde;adir Categoria</h1>
  <p>&nbsp;</p>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Descripcion:</td>
        <td><input type="text" name="strDescripcion" value="" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="Insertar registro" /></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
  <!-- InstanceEndEditable -->
   
    <!-- end .content --></div>
  <div class="footer">
    <p>Administracion Merca System</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
