<!-- modal legenda personalizada -->
<div id="modal-faixas-legenda" class="modal hide no-print" tabindex="-1" role="dialog" aria-labelledby="label-faixas-legenda" aria-hidden="true">
    
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="label-faixas-legenda"><?php echo $lang_mng->getString("mp_legenda_personalizada_titulo"); ?></h3>
    </div>
    
    <div class="modal-body">
        <div class="row">
            <form id="form_faixa_legenda"></form>
        </div>
    </div>
    
    <div class="modal-footer">
        <span class="btn" data-dismiss="modal"><?php echo $lang_mng->getString("mp_legenda_personalizada_cancelar"); ?></span>
        <span id="aplicar-novas-faixas" class="btn btn-primary"><i class="icon-refresh icon-white"></i> <?php echo $lang_mng->getString("mp_legenda_personalizada_aplicar_novos_valores"); ?></span> 
        <span id="aplicar-faixas-padrao" class="btn btn-primary"><i class="icon-off icon-white"></i> <?php echo $lang_mng->getString("mp_legenda_personalizada_retornar_padrao"); ?></span>
    </div>
</div>
<!-- /modal legenda personalizada -->
