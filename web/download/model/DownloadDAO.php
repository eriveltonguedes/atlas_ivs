<?php

Class Download {

    var $tipo;
    var $quantidadeRM;
    var $bd;
    var $nome;
    var $link;
    var $tabela;
    
    //Construtor
    public function __construct($tipo) {
        $this->tipo = $tipo;
        $this->quantidadeRM = 20;
        $this->bd = new bd();
//        $this->consultar();
//        $this->consultar();
    }
 
    //
    public function consultar(){
        echo 'consultar';
//        $this->tabela = '<table>';
//        $this->tabela .= '<tbody>';
        
        if ($this->tipo = 'rm'){
            $this->tabela = '</tbody>';
                    
            for($i = 0; $i < $this->quantidadeRM; $i++){
                $SQL = "SELECT nome, link_download FROM rm WHERE ativo = true AND id = $i ORDER BY nome ASC";
                $Resposta = pg_query($this->bd->getConexaoLink(), $SQL) or die('Não foi possível executar a consulta');
                
                while ($linha = pg_fetch_array($Resposta)) {
                    $this->nome = $linha['nome'];
                    $this->link = $linha['link_download'];
                    $this->montaTabela();
                }
            }
            $this->tabela = '<div style="width:100%; font-size: 57pt;font-family: "Passion One", Arial, sans-serif;color: #000000;height: 46px;padding-top: 30px;float: left;">Download</div>'

			.'<h3>Escolha abaixo os dados de indicadores e espacialidades para download.</h3>'
			   .'<table>'
                                .'<tbody>'
                                    .'<tr style="width: 100px; height: 35px;">'
                                        .'<td style="border-left: 1px solid #ccc; text-align: center; font-weight: bold; width: 100px;">Região Metropolitana</td>'
                                        .'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center; font-weight: bold; width: 100px;">Download</td>'
                                    .'</tr>'
				.'<tr style="width: 100px; height: 35px;">'
							.'<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">Dados Brutos dos municípios</td>'
							.'<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                .'<a href="data/rawData/atlas2013_dadosbrutos_pt.xlsx">'
                                    .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">Download</button>'
                                .'</a>'
                           .'</td>'
				.'</tr>';
//            $this->tabela .= $this->tabela.'</table>';
//            $this->tabela .= "</tbody></table>";
           echo $this->tabela;   
        }
    }
    
    //
    public function montaTabela(){
        $this->tabela .= '<tr style="width: 100px; height: 35px;">'.
                            '<td style="border-left: 1px solid #ccc; text-align: center;width: 100px;">'.$this->nome.'</td>';
                            '<td style="border-left: 1px solid #ccc; border-right: 1px solid #ccc; text-align: center;width: 100px;">'
                                .'<a href='.$this->link.'>'
                                    .'<button type="button" class="blue_button big_bt"  style="margin-top: 0px; font-size: 14px; height: 25px; margin-left: 40%; padding: 1px 15px;" id="download_buttonBaixe">Download</button>'
                                .'</a>'
                           .'</td>'.
                         "</tr>";
    }
    

}
