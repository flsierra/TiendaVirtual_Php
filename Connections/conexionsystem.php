<?php if (!isset($_SESSION)) {
  session_start();
}?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexionsystem = "localhost";
$database_conexionsystem = "mercasystem";
$username_conexionsystem = "root";
$password_conexionsystem = "";
$conexionsystem = mysql_pconnect($hostname_conexionsystem, $username_conexionsystem, $password_conexionsystem) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php
if (is_file("includes/funciones.php")){
include ("includes/funciones.php");
}
else
{
include ("../includes/funciones.php");
}
?>