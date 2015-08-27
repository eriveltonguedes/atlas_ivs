<!-- zoom mapa -->
<div id="zoom-mapa" class="noselect">
    <div id="zoom-mapa-maior">&plus;</div>
    <div id="zoom-mapa-menor" class="desativado">&minus;</div>
</div>
<!--  /zoom mapa -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#zoom-mapa-menor').click(function () {
            var mapa = MAPA_API.getMapa(),
                    zoom = mapa.zoom;

            if (!mapa.minZoom || mapa.minZoom <= zoom) {
                mapa.setOptions({zoom: zoom - 1});
            }
        });

        $('#zoom-mapa-maior').click(function () {
            var mapa = MAPA_API.getMapa(),
                    zoom = mapa.zoom;

            if (!mapa.maxZoom || mapa.minZoom <= zoom) {
                mapa.setOptions({zoom: zoom + 1});
            }
        });
    });
</script>