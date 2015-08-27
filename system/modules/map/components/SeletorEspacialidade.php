<?php
// internacialização espacialidade
$mapa_item_camada = array(
    ESP_MUNICIPAL           => $lang_mng->getString('mp_item_camada_mun'),
    ESP_REGIONAL            => $lang_mng->getString('mp_item_camada_reg'),
    ESP_UDH                 => $lang_mng->getString('mp_item_camada_udh'),
    ESP_ESTADUAL            => $lang_mng->getString('mp_item_camada_estado'),
    ESP_REGIAOMETROPOLITANA => $lang_mng->getString('mp_item_camada_rm'),
);
?>

<!-- espacialidade -->
<div id="seletor_espacialidade">
    
    <div id="select_espacialidade_container">
        <div id="select_espacialidade">
            <span id="label_seletor_espacialidade" class="label"><?php echo $lang_mng->getString('mp_label_seletor_espacialidade'); ?></span>
            <span id="espacialidade_atual"><?php echo $mapa_item_camada[ESPACIALIDADE_PADRAO]; ?></span>
            <!-- lista espacialidade -->
            <div class="lista-espacialidade no-print">
                <?php if (defined('CONTEXTO_PADRAO')) { ?>
                    <?php if (CONTEXTO_PADRAO == ESP_REGIAOMETROPOLITANA) { ?>
                        <ul>
                            <li id="item_espacialidade_6"><?php echo $lang_mng->getString('mp_item_camada_rm'); ?></li>
                            <li id="item_espacialidade_2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                            <li id="item_espacialidade_3"><?php echo $lang_mng->getString('mp_item_camada_reg'); ?></li>
                            <li id="item_espacialidade_5"><?php echo $lang_mng->getString('mp_item_camada_udh'); ?></li>
                        </ul>
                    <?php } else if (CONTEXTO_PADRAO == ESP_ESTADUAL) { ?>
                        <ul>
                            <li id="item_espacialidade_4"><?php echo $lang_mng->getString('mp_item_camada_estado'); ?></li>
                            <li id="item_espacialidade_2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                        </ul>
                    <?php } else if (CONTEXTO_PADRAO == ESP_PAIS) { ?>
                        <ul>
                            <li id="item_espacialidade_4"><?php echo $lang_mng->getString('mp_item_camada_estado'); ?></li>
                            <li id="item_espacialidade_2"><?php echo $lang_mng->getString('mp_item_camada_mun'); ?></li>
                        </ul>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <!-- aviso --
        <div id="aviso-ajuda-seletor-espacialidade" class="aviso-ajuda">
            <div class="close">&times;</div>
            <span class="passo-seletor-mapa">Passo 2</span>: Clique aqui para escolher outra camada do mapa.
        </div>

        <script>
            $(document).ready(function () {
//                $('#aviso-ajuda-seletor-espacialidade').delay(5000).fadeOut('fast');
                $('#aviso-ajuda-seletor-espacialidade .close').bind('click', function(evt) {
//                    $(this).parent().hide();
                    $('.aviso-ajuda').hide();
                    $('#botao-aviso-ajuda').removeClass('selecionado');
                    evt.stopPropagation();
                });
            });
        </script>
        !-- /aviso -->
        <!-- /lista espacialidade -->
    </div>
    
</div>
<!-- /espacialidade -->


<script type="text/javascript">
    $(document).ready(function() {
        $('#seletor_espacialidade').click(function(e) {
            $('.lista-espacialidade').toggle();
            $('#espacialidade_atual').toggleClass('highlight');
            $('#contexto_atual').removeClass('highlight');
            $('.lista-contexto,#indicador-holder,.aviso-ajuda').hide();
            $('#botao-aviso-ajuda').removeClass('selecionado');
            e.stopPropagation();
        });

        $('#select_espacialidade').delegate('li', 'click', function(event) {
            var espacialidade, id, indicador, ano;

            // recupera espacialidade do atributo id
            espacialidade = parseInt($(this).attr('id').replace(/[^0-9]/g, ''), 10);
            
            MAPA_API.setEspacialidade(espacialidade, true);

            // mostra aviso atual
            $('#espacialidade_atual').text($(this).text());

            // seletores do mapa
            id          = MAPA_API.getId();
            indicador   = MAPA_API.getIndicador();
            ano         = MAPA_API.getAno();

            if (indicador !== null && +ano === 1 
                    && (+espacialidade === ESP_CONSTANTES.udh 
                        || +espacialidade === ESP_CONSTANTES.regiaometropolitana)) {
                
                MAPA_API.mostraAviso1991();
            } else {
                if (id) {
                    MAPA_API.simpleMapQuery(
                        id,
                        espacialidade,
                        indicador,
                        ano,
                        MAPA_API.getContexto()
                    );
                }
            }

        }); // fim
    });
</script>