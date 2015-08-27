<script src="<?php echo $path_dir ?>assets/js/util.js"></script>
<script src="<?php echo $path_dir ?>assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>assets/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />

<!-- legenda -->
<link rel="stylesheet" type="text/css" href="<?php echo $path_dir ?>system/modules/map/assets/css/legenda.css" />

<div id="legenda_mapa" class="legenda_mapa">
    <h4 class="legenda_titulo"><?php echo $lang_mng->getString('mp_title_legenda'); ?></h4>

    <div id="legenda-container">
        <div id="legenda">
            <ul id="legenda_itens" class="legenda_itens"></ul>
        </div>
        <div id="legenda-quantil">
            <div class="info"><?php echo $lang_mng->getString("mp_info_quantil"); ?></div>
            <div class="form-legend">
                <input type="number" id="valor-quantil" name="valor-quantil" step="1" pattern="\d+" value="<?php echo FAIXAS_MAPA_PADRAO; ?>" max="<?php echo MAX_FAIXAS_MAPA; ?>" min="<?php echo MIN_FAIXAS_MAPA; ?>" class="input-mini" required="required" /> <input type="button" id="ok-quantil" value="<?php echo $lang_mng->getString("mp_button_legenda_ok"); ?>" class="btn btn-primary btn-small" />
            </div>
        </div>
        <div id="legenda-personalizada">
            <div class="info"><?php echo $lang_mng->getString('mp_info_legenda_personalizada'); ?></div>
            <div class="form-legend"><form><input type="button" id="edit-legenda-personalizada" value="<?php echo $lang_mng->getString("mp_button_legenda_editar"); ?>" class="btn btn-primary btn-small" /></form></div>
        </div>
    </div>

    <div id="legenda-tabs">
        <ul>
            <li id="tab-legenda-padrao" class="ativo"><?php echo $lang_mng->getString('mp_title_legenda_padrao'); ?></li>
            <li id="tab-legenda-quantil"><?php echo $lang_mng->getString('mp_title_quantil'); ?></li>
            <li id="tab-legenda-personalizada"><?php echo $lang_mng->getString('mp_title_legenda_personalizada'); ?></li>
        </ul>
    </div>
</div>

<script type="text/javascript">

    /**
     * Cria nova legenda a partir do componente.
     * 
     */
    function setFaixasLegendaPersonalizada() {
        var novasFaixas = [];

        $('#form_faixa_legenda .control-group').each(function () {
            var $this = $(this), cor, min, max, nome;

            cor = $this.find('.faixa_cor').css('backgroundColor');
            
            min = parseFloat(formataValor($this.find('.min').val()));
            max = parseFloat(formataValor($this.find('.max').val()));
            
            nome = MAPA_API.criaFaixaLegenda(max, min);

            novasFaixas.push({
                cor_preenchimento   : cor,
                nome                : nome,
                max                 : max,
                min                 : min
            });
        });        
        
        MAPA_API.setLegendaPersonalizada(novasFaixas);
        
        showLegenda();
    }


    /**
     * Legenda.
     * 
     * @returns {undefined}
     */
    function showLegenda() {
        $('#legenda').show();        
                    
        // reset valor quantil
        $('#valor-quantil').val(<?php echo FAIXAS_MAPA_PADRAO;?>);
    }


    $(document).ready(function () {
        var faixasLegenda,
                numFaixasLegenda,
                minFaixasLegenda = <?php echo MIN_FAIXAS_MAPA ?>,
                maxFaixasLegenda = <?php echo MAX_FAIXAS_MAPA ?>;


        $('#modal-faixas-legenda').on('shown', function () {
            $('#form_faixa_legenda .control-group').remove();
            var inputs, cor;
            
            faixasLegenda = MAPA_API.getFaixasLegenda(MAPA_API.TIPO_LEGENDA_PERSONALIZADA);
            numFaixasLegenda = faixasLegenda.length;
            
            $(faixasLegenda).each(function (i, item) {
                cor     = item['cor_preenchimento'];
                inputs  = '<input class="min faixa_valor input-small" name="faixa_min" value="' + formataValor(item['min'], true) + '" /> <input class="max faixa_valor input-mini" name="faixa_max" value="' + formataValor(item['max'], true) + '" />';
                
                $('#form_faixa_legenda').append('<div class="control-group"><span class="faixa_cor" style="background:' + cor + ';position:relative;" data-color="' + cor + '"></span>  ' + inputs + ' <span class="btn btn-mini btn-danger remove_faixa"><i class="icon-minus icon-white"></i> <?php echo $lang_mng->getString("mp_legenda_personalizada_remover"); ?></span> <span class="btn btn-mini btn-success adiciona_faixa"><i class="icon-plus icon-white"></i> <?php echo $lang_mng->getString("mp_legenda_personalizada_adicionar"); ?></span></div>');
            });

            // adiciona plugin para cor
            $('.faixa_cor').colorpicker().on('changeColor', function (ev) {
                this.style.backgroundColor = ev.color.toHex();
            });
        });


        /*
         * Remove faixa em legenda personalizada no modal. 
         */
        $('#modal-faixas-legenda').delegate('.remove_faixa', 'click', function () {
            if (numFaixasLegenda > minFaixasLegenda) {
                $(this).parent().remove();

                numFaixasLegenda -= 1;

                $('.adiciona_faixa').removeClass('disabled');

                if (numFaixasLegenda === minFaixasLegenda) {
                    $('.remove_faixa').addClass('disabled');
                }

                $('.faixa_cor').colorpicker().on('changeColor', function (ev) {
                    this.style.backgroundColor = ev.color.toHex();
                });
            }
        });


        /*
         * Adiciona nova faixa em legenda personalizada no modal. 
         */
        $('#modal-faixas-legenda').delegate('.adiciona_faixa', 'click', function () {
            if (numFaixasLegenda < maxFaixasLegenda) {
                var clone = $(this).parent().clone();

                $(this).parent().before(clone);

                numFaixasLegenda += 1;

                $('.remove_faixa').removeClass('disabled');

                if (numFaixasLegenda === maxFaixasLegenda) {
                    $('.adiciona_faixa').addClass('disabled');
                }

                $('.faixa_cor').colorpicker().on('changeColor', function (ev) {
                    this.style.backgroundColor = ev.color.toHex();
                });
            }
        });


        /*
         * Tab Legenda personalizada.
         */
        $("#tab-legenda-personalizada").click(function () {
            $(this).parent().find('.ativo').removeClass('ativo');

            $('#legenda-container > *').hide();
            $('#legenda-personalizada').show();

            if (MAPA_API.isLegendaPersonalizada()) {
                $('#legenda-personalizada .info').show();
            } else {
                $('#legenda-personalizada .info').hide();
                showLegenda();
            }

            $(this).addClass('ativo');

            MAPA_API.setLegendaPersonalizada();
        });


        /*
         * Dialogo edição de legenda personalizada.
         */
        $('#edit-legenda-personalizada').click(function () {
            $('#modal-faixas-legenda').modal();
        });

        /*
         * Tab Legenda padrão.
         */
        $("#tab-legenda-padrao").click(function () {
            $(this).parent().find('.ativo').removeClass('ativo');

            $('#legenda-container > *').hide();

            MAPA_API.setLegendaPadrao();
            showLegenda();

            $(this).addClass('ativo');
        });

        /*
         * Tab Legenda padrão.
         */
        $("#tab-legenda-quantil").click(function () {
            $(this).parent().find('.ativo').removeClass('ativo');
            $('#legenda-container > *').hide();
            $(this).addClass('ativo');
            $('#legenda-quantil').show();

            if (MAPA_API.existeQuantil()) {
                $('#legenda-quantil .info').show();
            } else {
                $('#legenda-quantil .info').hide();
                showLegenda();
                MAPA_API.atualizaQuantilMapa();
            }
        });

        $('#ok-quantil').click(function () {
            var numQuantil = parseInt($('#valor-quantil').val(), 10),
                    faixasQuantil = MAPA_API.quantil(numQuantil);

            MAPA_API.setLegendaQuantil(faixasQuantil);

            $('#legenda-quantil .info').hide();

            showLegenda();
        });


        /*
         * Funções legenda no dialog de legenda personalizada.
         */
        $("#aplicar-novas-faixas").click(function () {
            setFaixasLegendaPersonalizada();
            $('#modal-faixas-legenda').modal('hide');
            $('#legenda').show();
            $('#legenda-personalizada .info').hide();
        });

        /*
         * Aplica legenda padrão. 
         */
        $("#aplicar-faixas-padrao").click(function () {
            MAPA_API.resetLegendaPersonalizada();
            MAPA_API.setLegendaPadrao();
            MAPA_API.setAbaLegendaPadrao();

            $('#legenda-personalizada .info, #legenda-quantil .info').hide();
            $('#modal-faixas-legenda').modal('hide');
            $('#legenda').show();
        });
    });
</script>
<!-- /legenda -->