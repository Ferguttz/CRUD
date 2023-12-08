<?php
// Borra el elemento indicado de tabla de usuarios
// Reordena indexa la tabla
function accionBorrar ($id){
    
    if (isset($_SESSION['tuser'][$id])) {
        unset($_SESSION['tuser'][$id]);
        $msg = " El usuario con login $id ha sido eleminado";
    } else {
        $msg = " Error: El usuario con login $id no se encuentra";
    }

    $_SESSION['msg'] = $msg;

}

// Termina: Cierra sesión y vuelva los datos
function accionTerminar(){
    volcarDatos($_SESSION['tuser']);
    $_SESSION['msg'] = " Los datos se han guardado. ";
    
}
 

// Muestra un formularios cn los datos de un usuario de la posición $id de la tabla
function accionDetalles($id){
    $login=$id;
    $usuario = $_SESSION['tuser'][$id];
    $clave  = $usuario[0];
    $nombre   = $usuario[1];
    $comentario=$usuario[2];
    $orden = "Detalles";
    include_once "layout/formulario.php";
    exit();
}



// Muestra un el formularios con los datos permitiendo la modificación
function accionModificar($id){

    $login=$id;
    $usuario = $_SESSION['tuser'][$id];
    $clave  = $usuario[0];
    $nombre   = $usuario[1];
    $comentario=$usuario[2];
    $orden = "Modificar";
    include_once "layout/formulario.php";
    exit();
}




// Muestra un el formulario con los datos vacios para realizar una alta
function accionAlta(){
    $nombre  = "";
    $login   = "";
    $clave   = "";
    $comentario = "";
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

//Acción de alta con recuperación de datos 
function accionAltaRecuperacion($msg,$usuario){
    $nombre  = $usuario['nombre'];
    $login   = $usuario['login'];
    $clave   = $usuario['clave'];
    $comentario = $usuario['comentario'];
    $orden= "Nuevo";
    include_once "layout/formulario.php";
    exit();
}

//Acción de Modificar con recuperación de datos 
function accionModificarRecuperacion($msg,$usuario){
    $nombre  = $usuario['nombre'];
    $login   = $usuario['login'];
    $clave   = $usuario['clave'];
    $comentario = $usuario['comentario'];
    $orden= "Modificar";
    include_once "layout/formulario.php";
    exit();
}

// Proceso los datos del formularios guardandolo en la sesión
// Debe evitar que se puedan introducir dos usuarios con el mismo login
function accionPostAlta(){
 
    //<<<< COMPLETAR >>>>>>
    limpiarArrayEntrada($_POST); //Evito la posible inyección de código
    
    //<<<< COMPLETAR y CORREGIR>>>>>>
    $msg = "";

    //comprobar que no tiene espacios en blanco
    if (empty($_POST['nombre']) ||
        empty($_POST['login']) ||
        empty($_POST['clave']) ||
        empty($_POST['comentario'])) {
            $msg = "El nuevo usuario tiene espacios en blanco";
            die (accionAltaRecuperacion($msg,$_POST));
    }

    //comprobar que hay login repetido
    $id = $_POST['login'];
    if (isset($_SESSION['tuser'][$id])) {
        $msg = " El usuario con login '$id' ya existe";
        die (accionAltaRecuperacion($msg,$_POST));
    }

    $nuevo = [ $_POST['clave'],$_POST['nombre'],$_POST['comentario']];
    $_SESSION['tuser'][$id]= $nuevo;  
    $_SESSION['msg'] = " Nuevo usuario añadido.";
}


function accionPostModificar() {
    if (empty($_POST['nombre']) ||
    empty($_POST['login']) ||
    empty($_POST['clave']) ||
    empty($_POST['comentario'])) {
        $msg = "El usuario modificado tiene espacios en blanco";
        die (accionModificarRecuperacion($msg,$_POST));
    }


        $id = $_POST['login'];
        $nuevovalor = [ $_POST['clave'],$_POST['nombre'],$_POST['comentario']];
        $_SESSION['tuser'][$id]= $nuevovalor;  
        $_SESSION['msg'] = "Usuario con login '$id' actualizado";
}