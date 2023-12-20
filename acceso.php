<?php require_once('Connections/conexionsystem.php'); ?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['StrEmail'])) {
  $loginUsername=$_POST['StrEmail'];
  $password=$_POST['StrPassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "acceso_ok.php";
  $MM_redirectLoginFailed = "acceso_error.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexionsystem, $conexionsystem);
  
  $LoginRS__query=sprintf("SELECT idUsuario, strEmail, strPassword FROM usuario WHERE strEmail=%s AND strPassword=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexionsystem) or die(mysql_error());
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
$loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
	$_SESSION['MM_idUsuario'] = $row_LoginRS["idUsuario"];      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/Principal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
                  <h1><!-- InstanceBeginEditable name="Titulo" -->Acceso Usuario<br />
                  <!-- InstanceEndEditable --></h1>
                  <p><!-- InstanceBeginEditable name="Contenido" -->Accede a la p&aacute;gina con tus datos:<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST">
                    <p>
                      <label for="StrEmail"></label>
                      email 
                      <span id="sprytextfield1">
                      <input type="text" name="StrEmail" id="StrEmail" />
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no valido.</span></span> </p>
                    <p>Contrase&ntilde;a:
<label for="StrPassword"></label>
<span id="sprytextfield2">
<input type="password" name="StrPassword" id="StrPassword" />
<span class="textfieldRequiredMsg">Se necesita un valor.</span></span></p>
                    <p>
                      <input type="submit" name="button" id="button" value="Enviar" />
                    </p>
                  </form>
                  <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
                  </script>
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
