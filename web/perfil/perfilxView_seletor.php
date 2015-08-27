<link rel="stylesheet" href="assets/css/filter-search.css">
<script	src="system/modules/perfil/componentes/seletor-perfil/view/js/filter-search.js"></script>
<script	src="system/modules/perfil/componentes/seletor-perfil/view/js/seletor-espacialidade.js"></script>

<!--<div class="titleTable">-->
<!--    <div id="lugaresTabela"></div>-->
<div class="titleLugares" onclick=''>
    <div id="uimapindicator_selector_tabela">
        <!--             style="float: right; margin-right: 0px;">-->
        <div class="divCallOutLugares">
            <button type="button" class="blue_button big_bt" id="button-fs" style="margin-right: 31px !important; font-size: 14px; height: 34px;"></button>
        </div>
    </div>
    <!--        <h5 id="btn-spatiality" data-toggle="tooltip" data-original-title="Tooltip on right"></h5>-->
</div>
<!--    <div class="titleIndices" id="calloutIndicadores"></div>
    <div class="iconAtlas">-->

<!--    </div>-->
<!--</div>-->

<!-- INÍCIO MODAL DO SELETOR DE ESPACIALIDADE -->
<div class="modal hide fs">
    <!-- <div class="modal-dialog"> -->
    <div class="modal-body">
        <!-- <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modal title</h4>
        </div> -->
        <div class="span8 left-content">
            <div class="row-fluid row-search">
                <div class="span12">
                    <div class="form-inline">
                        <input type="text" class="input-large input-fs-search">

<!-- <span class="input-group-btn">
  <button class="btn btn-default button-fs-search" type="button"><i class="icon-search" style="margin: 3px;"></i></button>
</span> -->
                    </div><!-- /input-group -->
                </div><!-- /.span-6 -->					  
            </div>
            <div class="row-fluid">
                <div class="mensagem" id="msg-bottom-search"></div>
            </div>
            <div class="row-fluid selectors">
                <!-- <div class="container-fluid">
                        
                </div> -->
            </div>
        </div>
        <!--        <div class="span4 selecteds">
                    <div class="row-title-selecteds">
                        <h3 id="title-selecteds">Selecionados</h3>
                    </div>
                    <div class="itens-selecteds"></div>    		
                </div>-->

    </div><!-- /.modal-body -->
    <!--    <div class="modal-footer row-fluid">
            <button type="button" class="blue_button big_bt btn-ok-fs" data-backdrop="false" data-dismiss="modal" style="float:right;height:30px;font-size: 11pt;">Ok</button>
            <button type="button" class="btn btn-default" id="btn-clean-selecteds" style="float:right;"></button>
        </div>-->
    <!-- </div><!-- /.modal-dialog -->
</div><!-- /.modal -->		
<!-- FIM MODAL DO SELETOR DE ESPACIALIDADE -->

