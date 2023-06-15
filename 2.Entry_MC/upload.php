<?php
session_start();

if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $tempFile = $_FILES["photo"]["tmp_name"];
    
    // Directorio donde se guardarán las imágenes de perfil
    $targetDir = "profile_images/";
    
    // Nombre del archivo de imagen basado en el nombre de usuario
    $targetFile = $targetDir . "profile_" . $_SESSION["Usuario_Nombre"] . ".jpg";
    move_uploaded_file($tempFile, $targetFile);

    // Actualiza la base de datos con la ruta del archivo de imagen
    // Asociada al usuario actual ($_SESSION["username"])

    $_SESSION[$_SESSION["Usuario_Nombre"]]['profileImage'] = $targetFile;

    header("Location: home.php");
    exit;
}
?>

