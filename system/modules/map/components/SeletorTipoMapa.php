<!--  tipo mapa -->
<div id="tipo-mapa" class="noselect">
    <span id="tipo-mapa-satelite" class="tipo-mapa-satelite"><?php echo $lang_mng->getString('mp_tipo_mapa_satelite'); ?></span>
    <span id="tipo-mapa-estradas" class="tipo-mapa-estrada tipo-mapa-atual"><?php echo $lang_mng->getString('mp_tipo_mapa_estradas'); ?></span>
</div>
<!--  /tipo mapa -->

<script type="text/javascript">
    $(document).ready(function () {

        $('#tipo-mapa span').click(function () {
            var self = $(this), len, id, tipoMapaAtual;

            self.toggleClass('tipo-mapa-atual');
            tipoMapaAtual = self.parent().find('.tipo-mapa-atual');

            len = tipoMapaAtual.length;
            if (len === 0) {
                self.addClass('tipo-mapa-atual');
            } else {

                if (len === 1 && tipoMapaAtual.hasClass('tipo-mapa-satelite')) {
                    id = 1;
                } else if (len === 1 && tipoMapaAtual.hasClass('tipo-mapa-estrada')) {
                    id = 0;
                }

                // se os dois tipos de mapa forem selecionados 
                // modo híbrido.
                if (len === 2) {
                    id = 2;
                }
            }

            MAPA_API.setTipoDoMapaId(id);
        });

    });
</script>