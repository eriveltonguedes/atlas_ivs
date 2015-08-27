<style type="text/css">
.lista{
	list-style-type: none;
}
.lista img{
	float: left;
	width: 100px;
	cursor: pointer;
}
.lista h4 {
	color: #333;
	cursor: pointer;
}
.lista a{
	cursor: pointer;
}
.lista>li{
	border-bottom: #D2D2D2 1px solid;
	/*border-radius: 5px;*/
	min-height: 110px;
	margin-top: 15px;
	/*box-shadow: 0px 0px 11px 2px #ddd;*/
}
/*.lista>li:hover{
	box-shadow: 0px 0px 11px 2px #bbb;	
}*/
.data-noticia{
	float: right;
	margin: 5px;
}
</style>
<div class="lista-destaques" >
    <ul class="lista" >
        <li>
           <div class="data-noticia"> <i>25/11/2014 </i></div>
           <a id='destaques_metodologia' onclick="myfunction('3')" style="font-size:13px;" >
              <img src="./assets/img/icons/icon-atlas.png" />
          </a>
          <a id='destaques_metodologia' onclick="myfunction('3')" style="font-size:13px;" >
              <h4>Regiões Metropolitanas brasileiras têm Alto Índice de Desenvolvimento Humano Municipal, mostra Atlas Brasil</h4>
          </a>

          Atlas traz agora IDHM por mais de 9 mil áreas de 16 Regiões Metropolitanas brasileiras. 
          <a id='destaques_metodologia' onclick="myfunction('3')" style="font-size:13px;" >
             Saiba mais  
         </a><!-- <span class='ballMarker'>&bull;</span> -->
     </li>
     <li>
       <div class="data-noticia"> <i>25/11/2014 </i></div>
       <a id='destaques_metodologia' onclick="myfunction('2')" style="font-size:13px;" >
          <img src="./assets/img/icons/icon-atlas.png" />
      </a>
      <a id='destaques_metodologia' onclick="myfunction('2')" style="font-size:13px;" >
          <h4>Regiões metropolitanas avançam no desenvolvimento humano e reduzem disparidades</h4>
      </a>
      Estudo do PNUD, Ipea e Fundação João Pinheiro mostra avanços nas regiões metropolitanas, mas também revela a disparidade remanescente dentro dos municípios
      <a id='destaques_faixas_idhm' onclick="myfunction('2')" style="font-size:13px;">
          Saiba Mais
      </a><!-- <span class='ballMarker'>&bull;</span> -->
  </li>
    <li>
<div class="data-noticia"> <i>29/07/2013 </i></div>
    <a id='destaques_metodologia' onclick="myfunction('7')" style="font-size:13px;" >
        <img src="./assets/img/icons/icon-atlas.png" />
    </a>
    <a id='destaques_metodologia' onclick="myfunction('7')" style="font-size:13px;" >
        <h4>Atlas IDHM - Destaques</h4>
    </a>

    <!-- Atlas traz agora IDHM por mais de 9 mil áreas de 16 Regiões Metropolitanas brasileiras.  -->
    <a id='destaques_metodologia' onclick="myfunction('7')" style="font-size:13px;" >
        Saiba mais  
    </a><!-- <span class='ballMarker'>&bull;</span> -->
</li>
  <li>
<div class="data-noticia"> <i>29/07/2013 </i></div>
    <a id='destaques_metodologia' onclick="myfunction('4')" style="font-size:13px;" >
        <img src="./assets/img/icons/icon-atlas.png" />
    </a>
    <a id='destaques_metodologia' onclick="myfunction('4')" style="font-size:13px;" >
        <h4>Atlas IDHM - Destaques Educação</h4>
    </a>

    <!-- Atlas traz agora IDHM por mais de 9 mil áreas de 16 Regiões Metropolitanas brasileiras.  -->
    <a id='destaques_metodologia' onclick="myfunction('4')" style="font-size:13px;" >
        Saiba mais  
    </a><!-- <span class='ballMarker'>&bull;</span> -->
</li>

  <li>
<div class="data-noticia"> <i>29/07/2013 </i></div>
    <a id='destaques_metodologia' onclick="myfunction('5')" style="font-size:13px;" >
        <img src="./assets/img/icons/icon-atlas.png" />
    </a>
    <a id='destaques_metodologia' onclick="myfunction('5')" style="font-size:13px;" >
        <h4>Atlas IDHM - Destaques Longevidade</h4>
    </a>

    <!-- Atlas traz agora IDHM por mais de 9 mil áreas de 16 Regiões Metropolitanas brasileiras.  -->
    <a id='destaques_metodologia' onclick="myfunction('5')" style="font-size:13px;" >
        Saiba mais  
    </a><!-- <span class='ballMarker'>&bull;</span> -->
</li>
  <li>
<div class="data-noticia"> <i>29/07/2013 </i></div>
    <a id='destaques_metodologia' onclick="myfunction('6')" style="font-size:13px;" >
        <img src="./assets/img/icons/icon-atlas.png" />
    </a>
    <a id='destaques_metodologia' onclick="myfunction('6')" style="font-size:13px;" >
        <h4>Atlas IDHM - Destaques Renda</h4>
    </a>

    <!-- Atlas traz agora IDHM por mais de 9 mil áreas de 16 Regiões Metropolitanas brasileiras.  -->
    <a id='destaques_metodologia' onclick="myfunction('6')" style="font-size:13px;" >
        Saiba mais  
    </a><!-- <span class='ballMarker'>&bull;</span> -->
</li>

<!--                 <li><a id='destaques_idhmBrasil' onclick="myfunction('3')" style="font-size:13px;" 
                <?php
                if ($separator[1] == 'idhm_brasil')
                    echo 'class="ativo2"';
                ?> ></a><span class='ballMarker'>&bull;</span>
            </li>
            <li><a id='destaques_educacao' onclick="myfunction('4')" style="font-size:13px;" 
                <?php
                if ($separator[1] == 'educacao')
                    echo 'class="ativo2"';
                ?> ></a><span class='ballMarker'>&bull;</span>
            </li>
            <li><a id='destaques_longevidade' onclick="myfunction('5')" style="font-size:13px;" 
                <?php
                if ($separator[1] == 'longevidade')
                    echo 'class="ativo2"';
                ?> ></a><span class='ballMarker'>&bull;</span>
            </li>
            <li><a id='destaques_renda' onclick="myfunction('6')" style="font-size:13px;" 
                <?php
                if ($separator[1] == 'renda')
                    echo 'class="ativo2"';
                ?> ></a>
            </li> -->
        </ul>
    </div>

