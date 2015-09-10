<style type="text/css">
	.bs-tables{
	   margin: 20px;
	   height: 100%;
	}
	.table {
	  width: 100%;
	  margin-bottom: 20px;
	}

	.table th,
	.table td {
	  padding: 8px;
	  line-height: 20px;
	  text-align: left;
	  vertical-align: top;
	  border-top: 1px solid #dddddd;
	}

	.table th {
	  font-weight: bold;
	}

	.table thead th {
	  vertical-align: bottom;
	}

	.table tbody + tbody {
	  border-top: 2px solid #dddddd;
	}

	.table .table {
	  background-color: #ffffff;
	}
</style>


<?php

Class Download {

    var $tipo;
    var $quantidadeRM;
    var $bd;
    var $nome;
    var $link;
    var $tabela;
    var $lang;

    //Construtor
    public function __construct($tipo, $lang) {
        $this->tipo = $tipo;
        $this->lang = $lang;
        $this->bd = new bd();
    }

    //
    public function consultar() {
        if ($this->tipo = 'rm') {
            $this->tabela .='<div class="bs-tables">'
			.'<div style="width:100%; font-size: 57pt;font-family:Passion One, Arial, sans-serif; color: #000000; height:46px;'
 .'padding-top: 30px; padding-bottom: 30px; float: left;">'.$this->lang->getString("download_title").'</div>'
			    .'<table class="table" style="width:100%;" >'
                            .'<tbody>'
                                .'<tr style="width: 100px; height: 35px;">' .
                                    '<td colspan="2" style=" border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center; font-weight: bold; width: 100px;" id="download_rm">'.$this->lang->getString("download_ivs").'</td>' .
                                '</tr>'
			.'<tr style="width: 100px; height: 35px;">'
				.'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->lang->getString("download_dados_ivs").'</td>'
				.'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                	.'<a href="data/rawData/atlasivs_dadosbrutos_pt.xlsx">'
                                    		.'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">'.$this->lang->getString("download_title").'</button>'
                                	.'</a>'
                           	.'</td>'
			.'</tr>'
            .'<tr style="width: 100px; height: 35px;border-bottom: 1px solid #ccc;">'
                .'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->lang->getString("download_pub_ivs").'</td>'
                .'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                    .'<a href="data/rawData/publicacao_atlas_ivs.pdf" target="_blank">'
                                            .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">'.$this->lang->getString("download_title").'</button>'
                                    .'</a>'
                            .'</td>'
            .'</tr>'

		/*.'<tr style="width: 100px; height: 35px;">' .
		                            '<td colspan="2" style=" border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center; font-weight: bold; width: 100px;" id="download_rm">'.$this->lang->getString("download_rm").'</td>' .
		                            '</tr>'
        .'</tr>'
            .'<tr style="width: 100px; height: 35px;">'
                .'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->lang->getString("download_publicacao_rm").'</td>'
                .'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                    .'<a href="data/rawData/publicacao_atlas_rm.pdf" target="_blank">'
                                            .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">'.$this->lang->getString("download_title").'</button>'
                                    .'</a>'
                            .'</td>'
            .'</tr>'
            .'<tr style="width: 100px; height: 35px;">'
                .'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->lang->getString("download_atlas_editorado_web").'</td>'
                .'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                    .'<a href="data/rawData/atlas_editorado_web.pdf" target="_blank">'
                                            .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">'.$this->lang->getString("download_title").'</button>'
                                    .'</a>'
                            .'</td>'
            .'</tr>'
			.'<tr style="width: 100px; height: 35px;">'
                .'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->lang->getString("download_agregacao_udh").'</td>'
                .'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                    .'<a href="data/rawData/agrupamento_UDHs_para_calculo_no_IBGE_2000_2010.xlsx">'
                                            .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">'.$this->lang->getString("download_title").'</button>'
                                    .'</a>'
                            .'</td>'
            .'</tr>'*/;
            
        }
	
        /*$SQL = "SELECT DISTINCT nome,link_download FROM $this->tipo WHERE ativo = true and link_download is not null ORDER BY nome ASC";

        $Resposta = pg_query($this->bd->getConexaoLink(), $SQL) or die('Não foi possível executar a consulta');

        while ($linha = pg_fetch_array($Resposta)) {
            $this->nome = $linha['nome'];
            $this->link = $linha['link_download'];
            $this->montaTabela();
        }*/
        $this->tabela .= '</tbody></table></div>';
        echo $this->tabela;
    }

    //
    public function montaTabela() {

        $this->tabela .='<tr style="width: 100px; height: 35px; border-bottom: 1px solid #ccc;">' .
                            '<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">' . $this->nome . '</td>' .
                            '<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: right;width: 100;">'
                                .'<a href='. $this->link .' target="_blank">'	
                                    .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; 							height: 25px; margin-left: 40%; padding: 1px 15px; color:#fff;" id="download_button">'.$this->lang->getString("download_button").'</button>'
                                .'</a>'

                            .'</td>' .
                        "</tr>";
    }
}
