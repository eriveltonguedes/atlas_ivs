<?php
    require_once '../../../config/conexao.class.php';
    require_once '../../../config/config_path.php';
    require_once '../../../com/mobiliti/consulta/Consulta.class.php';
    require_once '../model/DownloadDAO.php';
    
    $tipo = $_POST['tipo'];
    
    $download = new Download($tipo);
//    echo json_encode($download->consultar()); 
    