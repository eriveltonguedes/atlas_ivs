<?php    
    require_once '../../../../config/conexao.class.php';
    require_once '../../../../config/config_path.php';
    require_once '../../../../system/modules/tabela/consulta/Consulta.class.php';
    require_once '../model/histogramDAO.php';
    
//    echo 'Entrei';
    
    //Pega os lugares
    $lugares = $_POST['lugares'];
//    echo $lugares;
    $espacialidadeSelecionada = $_POST['espacialidade'];    //Espacialidade Selecionada
//    var_dump($lugares);
//    print_r($lugares);
    
//    Pega o array com os valores da espacialidade selecionada
    $lugares2 = array();
//    foreach ($lugares as $key => $val){
//        if($key == 'id'){
//            $lugares2 = explode(',', $val);
//            echo $lugares2['ids'].'  ';
//        }
//        echo 'Key: '.$key.'  ';
//        echo 'Val: '.$val.'  ';
        
//        if ($val['e'] == $espacialidadeSelecionada){
//            $lugares2 = $val;
//        }
//    }
//    var_dump($lugares2);
//print_r($lugares);
    
//    $lugares2['ids'] = explode(',', $lugares['est']);
    //Pega indicador e ano
    $indicador = $_POST['indicador'];
//    echo $indicador;
    $ano = $_POST['ano'];
//    echo $ano;

    $arrayConsulta = array();
    $arrayConsulta[] = $espacialidadeSelecionada;
    $arrayConsulta[] = $lugares;
    $arrayConsulta[] = $indicador;
    $arrayConsulta[] = $ano;

    
    $histograma = new Histogram($arrayConsulta);
    echo json_encode($histograma->DrawHistograma()); 
?>