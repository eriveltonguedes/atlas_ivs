<?php

/**
 * Classe para Legenda.
 * 
 * @package map
 * @author AtlasBrasil
 */
class LegendaPadraoDao {

    /**
     * Conexão com banco de dados.
     *
     * @var Conexao
     */
    protected $db;

    /**
     * Construtor.
     *
     * @param Conexao $conexao            
     */
    public function __construct(Bd $conexao) {
        $this->bd = $conexao;
    }

    /**
     * Formata SQL legenda.
     * 
     * @param int|string $indicador
     * @param int|string $espacialidade
     * @return string
     */
    public function carrega($indicador, $espacialidade) {
        $ind = Bd::escape($indicador);
        $esp = VerificadorEspacialidade::getEspacialidade($espacialidade);
        
        $maior_melhor = null;
        
        $sql = "SELECT
                cg.id AS cg_id, 
                c.id AS c_id, 
                c.nome AS nome,                
                v.maiormelhor AS maior_melhor,
                CAST(c.maximo AS varchar) AS max,
                CAST(c.minimo AS varchar) AS min,
                c.cor_preenchimento AS cor_preenchimento
            FROM
                classe_grupo AS cg, classe AS c, variavel AS v
            WHERE
                c.fk_classe_grupo=cg.id AND
                v.id=cg.fk_variavel AND
                cg.fk_variavel={$ind} AND
                cg.espacialidade={$esp}
            ORDER BY
                c_id DESC";

        $this->bd->execSql($sql);

        $legenda = new LegendaPadrao();
        while ($row = $this->bd->proximo()) {
            $faixa = new FaixaLegenda();
            $faixa->setId($row->c_id);
            $faixa->setNome($row->nome);
            $faixa->setCor($row->cor_preenchimento);
            $faixa->setMax($row->max);
            $faixa->setMin($row->min);
            $legenda->addFaixa($faixa);
            
            // seta ordem das ASC ou DESC da legenda
            if ($maior_melhor == null) {
                $maior_melhor = $row->maior_melhor;
                $legenda->setOrdem($maior_melhor);
            }
        }
        
//        die($sql);
        return $legenda;
    }

}
