<?php
    $url = str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]);
    $separator = explode("/",$_GET["cod"]);
    
    if($separator[0] == "pt" || $separator[0] == "en" || $separator[0] == "es")
    {
        array_shift ( $separator );
    } 

?>

<script type="text/javascript">
    function myfunction2(valor){//só para redirecionar
        lang = '<?=$_SESSION["lang"]?>';
        pag = '<?=$path_dir?>' + lang + '/o_atlas/metodologia/';

        if(valor == 1){
            url = pag + "calculo-do-ivs/";
            /*url = pag + "calculo-do-idhm-e-seus-subindices/";*/
        }

        else if(valor == 2){
            url = pag + "ivs_dados/";
            
        }

        else if(valor == 3){
            url = pag + "ivs_renda/";
        }

        else if(valor == 4){
            url = pag + "construcao-das-unidades-de-desenvolvimento-humano/";
        }
        
        location.href= url;
    }
</script>

<div id="processo" style="width:900px;">
    <div class="areatitle" id='atlas_Metodologia'></div>
    
    <div class="menuAtlasMet">
        <ul class="menuAtlasMetUl">
                <li>
                    <a id="atlas_aba_1" onclick="myfunction2('1')" 
                <?php if($separator[2] == 'calculo-do-ivs' || $separator[0] == '') {echo 'class="ativo2"'; } ?>> CÁLCULO DO IVS </a>
                <span class='ballMarker'>&bull;</span>
                </li>              
                <li><a id="atlas_menuIvsDados" onclick="myfunction2('2')" 
                <?php if($separator[2] == 'ivs_dados' || $separator[0] == '') {echo 'class="ativo2"'; } ?>>FONTES DE DADOS</a><!--<span class='ballMarker'>&bull;</span>--></li>
            <!--<li><a id="atlas_menuIvs" onclick="myfunction2('2')" 
                <?php if($separator[2] == 'idhm_educacao') {echo 'class="ativo2"';}?> >IVS EDUCAÇÃO</a><span class='ballMarker'>&bull;</span></li>
            <li><a id="atlas_menuIvs" onclick="myfunction2('3')" 
                <?php if($separator[2] == 'idhm_renda') {echo 'class="ativo2"';} ?> >IVS RENDA</a></li>
                <li>
                    <a id="atlas_aba_2" onclick="myfunction2('4')" 
                <?php if($separator[2] == 'construcao-das-unidades-de-desenvolvimento-humano') {echo 'class="ativo2"';}?> >IDHM EDUCAÇÃO</a>
                <!-- <span class='ballMarker'>&bull;</span> -->
                </li>
        </ul>
    </div>
    <div class="linhaDivisoriaMet"></div>
    <div class="title-geral">
        <h1>O IVS</h1>
<p>O IVS é o resultado da média aritmética dos subíndices: IVS Infraestrutura Urbana, IVS Capital Humano e IVS Renda e Trabalho, cada um deles entra no cálculo do IVS final com o mesmo peso.</p>
<p>Para o cálculo dos subíndices, foram utilizados dezesseis indicadores calculados a par-tir das variáveis dos censos demográficos do IBGE, para os anos de 2000 e 2010 – tabulados para o ADH no Brasil3 – com seus respectivos pesos. Para a construção de cada dimensão do IVS, utilizando os pesos equivalentes para cada indicador, foi necessário utilizar parâmetros máximos e mínimos, em cada indicador, para transformá-lo, também, num indicador padro¬nizado, com valores variando de 0,000 a 1,000. 
</p>
    </div>
    <p>Cada indicador teve seu valor normalizado numa escala que varia entre 0 a 1, em que 0 corresponde à situação ideal, ou desejável, e 1 corresponde à pior situação. </p>
    <p>A condição de absoluta ausência de vulnerabilidade equivale a 0% de casos indesejados (ou por exemplo zero mortos por mil nascidos vivos, no caso da variável taxa de mortalidade de crianças de até 1 ano de idade). </p>
    <p>Já o valor máximo de cada indicador – ou seja, a situação de máxima vulnerabilidade – foi estabelecido a partir da média encontrada para os dados municipais de cada um deles, considerando, para efeitos de cálculo, os valores relativos aos anos de 2000 e 2010, acrescido de dois desvios-padrão, limitado em 1, mesmo para os municípios que extrapolaram este valor. </p>
    <p>Sendo assim, foi considerada como situação ideal (ausência de vulnerabilidade social) a não ocorrência de casos em cada uma das dimensões (por exemplo, mortalidade infantil igual a zero) e o valor máximo correspondeu, sempre, à pior situação encontrada a partir da padronização referida. Todos os indicadores listados apresentam relação direta com situações de vulnerabilidade social: quanto maior o indicador, maior a vulnerabilidade social. Feita a normalização dos dados para os indicadores que compõem o subíndice, foram aplicados os pesos relativos a cada um dos indicadores.</p>

    
    <?php
                if($separator[2] == 'ivs_dados' || $separator[1] == ''){
                    include 'o_atlas/'.$_SESSION["lang"].'/ivsDadosView.php';
                }

                else if($separator[2] == 'calculo-do-ivs'){
                    include 'o_atlas/'.$_SESSION["lang"].'/ivsCalculoView.php';
                }
                
               /* else if($separator[2] == 'construcao-das-unidades-de-desenvolvimento-humano'){
                    include 'o_atlas/'.$_SESSION["lang"].'/construcaoUnidadesDesenvolvimentoHumano.php';
                }
                
                else if($separator[2] == 'idhm_renda'){
                    include 'o_atlas/'.$_SESSION["lang"].'/idhmRendaView.php';
                }*/
            ?>
</div>

<script type="text/javascript">
    $("#atlas_Metodologia").html(lang_mng.getString("atlas_Metodologia"));
    $("#atlas_aba_1").html(lang_mng.getString("atlas_metodologia_aba_1"));
    $("#atlas_aba_2").html(lang_mng.getString("atlas_metodologia_aba_2"));
    /*$("#atlas_menuIdhmEducacao").html(lang_mng.getString("atlas_menuIdhmEducacao"));
    $("#atlas_menuIdhmRenda").html(lang_mng.getString("atlas_menuIdhmRenda"));*/
</script>