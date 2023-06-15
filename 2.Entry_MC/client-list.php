<?php
// Nombre, apellido y rol en pantalla
session_start(); // Iniciar sesión o reanudar una sesión existente

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['Usuario_Id'])) {
    // El usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli($servidor = "localhost", $usuario = "root", $password = "", $db = "entry_mc");

// Verificar si la conexión fue exitosa
if ($conexion->connect_errno) {
    echo 'Error al conectar a la base de datos: ' . $conexion->connect_error;
    exit();
}

// Obtener el ID del usuario autenticado desde la sesión
$usuario_id = $_SESSION['Usuario_Id'];

// Consulta para obtener el nombre de usuario, apellido de usuario y el nombre de rol del usuario autenticado
$sql = "SELECT u.Nombre_Usuario, u.Apellido_Usuario, r.Nombre_Rol FROM Usuarios u JOIN Roles r ON u.Id_Rol = r.Id_Rol WHERE u.Id_Usuario = $usuario_id";
$resultado = $conexion->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $nombre_usuario = $fila["Nombre_Usuario"];
    $apellido_usuario = $fila["Apellido_Usuario"];
    $nombre_rol = $fila["Nombre_Rol"];
} else {
    $nombre_usuario = "";
    $apellido_usuario = "";
    $nombre_rol = "";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<?php
include("./Conexion/Conexion.php");
include("./Controlador/categoriaControlador.php");


if($_POST){
    $obj->Usuario_Nombre = $_POST['Nombre_Usuario'];
}
$cone = new Conexion();
$c = $cone -> conectando();
$queryCantUsuarios = "SELECT COUNT(*) AS TotalRegistros FROM usuarios";
$ejecuta = mysqli_query($c,$queryCantUsuarios);
$TotalRegistros = mysqli_fetch_array($ejecuta)['TotalRegistros'];

$maximoRegistros = 100;
if(empty($_GET['pagina'])){
	$pagina=1;
}else{
	$pagina=$_GET['pagina'];
}
$desde = ($pagina-1)*$maximoRegistros;
$totalRegistros=ceil($TotalRegistros/$maximoRegistros);

$query = "SELECT Id_Usuario, Nombre_Usuario, Apellido_Usuario, R.Nombre_Rol, Nombre_Documento, Numero_Documento, Direccion, Correo_Electronico, Celular, EU.Nombre_Estado, Login, Password
FROM usuarios U 
INNER JOIN tipo_documentos TP ON U.Tipo_Documento = TP.Id_Tipo_Documento 
INNER JOIN estados_usuarios EU ON U.Estado_Usuario = EU.ID_ESTADO_USUARIO
INNER JOIN roles R ON U.Id_rol = R.Id_Rol ORDER BY U.Id_Usuario limit $desde,$maximoRegistros" ;

$ejecuta = mysqli_query($c,$query);
$usuarios = mysqli_fetch_array ($ejecuta);

/* echo $TotalRegistros; */
?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Lista de clientes</title>

	<!-- Normalize V8.0.1 -->
	<link rel="stylesheet" href="./css/normalize.css">

	<!-- Bootstrap V4.3 -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">

	<!-- Bootstrap Material Design V4.0 -->
	<link rel="stylesheet" href="./css/bootstrap-material-design.min.css">

	<!-- Font Awesome V5.9.0 -->
	<link rel="stylesheet" href="./css/all.css">

	<!-- Sweet Alerts V8.13.0 CSS file -->
	<link rel="stylesheet" href="./css/sweetalert2.min.css">

	<!-- Sweet Alert V8.13.0 JS file-->
	<script src="./js/sweetalert2.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">
	
	<!-- General Styles -->
	<link rel="stylesheet" href="./css/style.css">


</head>
<body>
	
	<!-- Main container -->
	<main class="full-box main-container">
		<!-- Nav lateral -->
		<section class="full-box nav-lateral">
			<div class="full-box nav-lateral-bg show-nav-lateral"></div>
			<div class="full-box nav-lateral-content">
				<figure class="full-box nav-lateral-avatar">
					<i class="far fa-times-circle show-nav-lateral"></i>
					<img src="./assets/avatar/Avatar.png" class="img-fluid" alt="Avatar">
					<figcaption class="roboto-medium text-center"> 
                     <small class="roboto-condensed-light">Bienvenido,  
						<?php echo $nombre_usuario;?> 
						<?php echo $apellido_usuario; ?>
						 <p>Rol: <?php echo $nombre_rol; ?></p>
						 <br></small>
					</figcaption>  
				</figure>
				
				<div class="full-box nav-lateral-bar"></div>
				<nav class="full-box nav-lateral-menu">
					<ul>
						<li>
							<a href="home.php"><i class="fas fa-home"></i> &nbsp; Dashboard</a>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-sliders-h"></i> &nbsp; Administracion <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="client-list.php"><i class="fas fa-user fa-fw"></i> &nbsp; Usuarios</a>
								</li>
								<li>
									<a href="Vehiculo-list.php"><i class="fas fa-bus-alt"></i> &nbsp; Vehículos</a>
								</li>
								<li>
									<a href="roles.php"><i class="fas fa-briefcase"></i> &nbsp; Roles</a>
								</li>
								<li>
									<a href="client-search.html"><i class="fas fa-key"></i> &nbsp; Permisos</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-keyboard"></i> &nbsp; Registros Patios <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="Registro-Entrada-List.php"><i class="fas fa-bus"></i> &nbsp; Entrada Vehiculos</a>
								</li>
								<li>
									<a href="Registro-Salida-list.php"><i class="fas fa-bus"></i> &nbsp; Salida Vehiculos</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="#" class="nav-btn-submenu"><i class="fas fa-search"></i> &nbsp; Consultas <i class="fas fa-chevron-down"></i></a>
							<ul>
								<li>
									<a href="reservation-new.html"><i class="fas fa-ticket-alt"></i> &nbsp; Ordenes de Trabajo</a>
								</li>
						</li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</section>

		<!-- Page content -->
		<section class="full-box page-content">
			<nav class="full-box navbar-info">
				<a href="#" class="float-left show-nav-lateral">
					<i class="fas fa-exchange-alt"></i>
				</a>
				<a href="client-update.php">
					<i class="fas fa-user-cog"></i>
				</a>
				<a href="#" class="btn-exit-system">
					<i class="fas fa-power-off"></i>
				</a>
			</nav>

			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
				<p class="text-justify">
					GESTIÓN DE USUARIOS DE LA PLATAFORMA EntryMC 
				</p>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="client-new.php"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR USUARIO</a>
					</li>
					<li>
						<a class="active" href="client-list.php"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
				</ul>	
			</div>
			</form>
			<?php


			?>
			</div>
			
			
			<!-- Content here-->
			<div class="container-fluid">
				<div class="table-responsive">
					<table class="table table-dark table-sm">
						<thead>
						<!DOCTYPE html>
<html>
<head>
  <title>Filtro de tabla</title>
  <script>
    function filtrarTabla() {
      // Obtener el valor del campo de búsqueda
      var filtro = document.getElementById("filtro").value.toUpperCase();

      // Obtener la tabla y las filas
      var tabla = document.getElementById("tabla");
      var filas = tabla.getElementsByTagName("tr");

      // Recorrer las filas de la tabla y ocultar las que no coinciden con el filtro
      for (var i = 0; i < filas.length; i++) {
        var celdas = filas[i].getElementsByTagName("td");
        var mostrarFila = false;
        for (var j = 0; j < celdas.length; j++) {
          var textoCelda = celdas[j].innerText.toUpperCase();
          if (textoCelda.indexOf(filtro) > -1) {
            mostrarFila = true;
            break;
          }
        }
        filas[i].style.display = mostrarFila ? "" : "none";
      }
    }
  </script>
</head>
<body>
<div class="container-fluid">
  <div class="table-responsive">
  <h2>Filtro de Busqueda</h2>
  <input type="text" id="filtro" onkeyup="filtrarTabla()" placeholder="Buscar usuario">
  <br><br>
  
  <table id="tabla" class="table table-dark table-sm">
  <tr class="text-center roboto-medium">
								<th>#</th>
								<th>Nombre</th>
								<th>Apellido</th>
								<th>Rol</th>
								<th>Tipo Documento</th>
								<th>Numero Documento</th>
								<th>Dirección</th>
								<th>Correo Electrónico</th>
								<th>Celular</th>
								<th>Estado</th>
								<th>Login</th>
								<th>ACTUALIZAR</th>
								<th>ELIMINAR</th>
							</tr>
						</thead>
							<?php
							if($usuarios==0){
								echo"No hay Registros";
							}else{
								do{
							?>
							

						<tbody>
							<tr class="text-center" >
								<td><?php echo $usuarios[0]?></td>
								<td><?php echo $usuarios[1]?></td>
								<td><?php echo $usuarios[2]?></td>
								<td><?php echo $usuarios[3]?></td>
								<td><?php echo $usuarios[4]?></td>
								<td><?php echo $usuarios[5]?></td>
								<td><?php echo $usuarios[6]?></td>
								<td><?php echo $usuarios[7]?></td>
								<td><?php echo $usuarios[8]?></td>
								<td><?php echo $usuarios[9]?></td>
								<td><?php echo $usuarios[10]?></td>
								</td>
								<td>
									<a href=" <?php if($usuarios[0] <> ''){
										echo "client-update.php?key=".urlencode($usuarios[0]);
									}  ?>"
									class="btn btn-success">
									<i class="fas fa-edit"></i>
									</a>
								</td>
								<td>
									<a href=" <?php if($usuarios[0] <> ''){
										echo "client-delete.php?key=".urlencode($usuarios[0]);
									}  ?>"
										class="btn btn-warning">
		  								<i class="far fa-trash-alt"></i>
										</button>
									</form>
							<?php
								}while($usuarios = mysqli_fetch_array($ejecuta));
							}
							?>
							
						</tbody>
  </table>
  </div>
  </div>
</body>
</html>
					</table>
				</div>
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
					<?php 
                    if($pagina!=1){
                    ?>
                    <li class="page-item ">
                        <a class="page-link" href="?pagina=<?php echo 1; ?>"><</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina-1; ?>"><<</a>
                    </li>
                    <?php
                    }
                    for($i=1; $i<=$totalRegistros; $i++){
                        if($i==$pagina){
                            echo'<li class="page-item active" aria-current="page"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';    
                        }
                        else{
                            echo'<li class="page-item "><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>'; 
                        }
                    }
                    if($pagina !=$totalRegistros){
                    ?>
                    
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $pagina+1; ?>">>></a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?pagina=<?php echo $totalRegistros; ?>">></a>
                    </li>
                    <?php
                    }
                    ?>
						</li>
					</ul>
				</nav>
			</div>
			

		</section>
	</main>
	
	
	<!--=============================================
	=            Include JavaScript files           =
	==============================================-->
	<!-- jQuery V3.4.1 -->
	<script src="./js/jquery-3.4.1.min.js" ></script>

	<!-- popper -->
	<script src="./js/popper.min.js" ></script>

	<!-- Bootstrap V4.3 -->
	<script src="./js/bootstrap.min.js" ></script>

	<!-- jQuery Custom Content Scroller V3.1.5 -->
	<script src="./js/jquery.mCustomScrollbar.concat.min.js" ></script>

	<!-- Bootstrap Material Design V4.0 -->
	<script src="./js/bootstrap-material-design.min.js" ></script>
	<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

	<script src="./js/main.js" ></script>
</body>
</html>