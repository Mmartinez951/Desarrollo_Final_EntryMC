<?php
session_start();

// Obtén el nombre del archivo de imagen de la base de datos para el usuario actual ($_SESSION["username"])
$profileImage = isset($_SESSION[$_SESSION["Usuario_Nombre"]]['profileImage']) ? $_SESSION[$_SESSION["Usuario_Nombre"]]['profileImage'] : 'profile.jpg';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil de Usuario</title>
</head>
<body>
    <h1>Perfil de Usuario</h1>
    <h2>Foto de Perfil:</h2>
    <img src="<?php echo $profileImage; ?>" alt="Foto de Perfil" />
    <h2>Nombre de Usuario: <?php echo $_SESSION["Usuario_Nombre"]; ?></h2>
</body>
</html>


