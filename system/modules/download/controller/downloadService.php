<?php
    require_once BASE_ROOT .'config/conexao.class.php';
    require_once BASE_ROOT .'config/config_path.php';
    require_once BASE_ROOT . 'system/modules/tabela/consulta/Consulta.class.php';
    require_once BASE_ROOT .'system/modules/download/model/DownloadDAO.php';
    require_once BASE_ROOT .'config/langs/LangManager.php';
    
    if(isset($_POST['tipo'])) {
        $tipo = $_POST['tipo'];
    } else {
        $tipo = '';
    }
    
    $download = new Download($tipo, $lang_mng);
