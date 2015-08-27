<?php

/**
 * Classe SQL para diferentes tipos de espacialidades.
 * 
 * @package map
 * @author AtlasBrasil
 */
class SqlEspacialidade {

    /**
     * Sql resultante.
     * 
     * @var string 
     */
    private $sql = '';

    /*
     * Tabela.
     * 
     * @var string
     */
    private $tabela = '';

    /**
     * Constroi sql dos IDs de espacialidades diferente.
     *
     * @param string $contexto        	
     * @param string $espacialidade  	
     * @param array $array_id           Lista de IDs da espacialidade      	
     * @return array
     */
    public function getSqlByIdEspacialidade($contexto, $espacialidade, $array_id)
    {
        $this->tabela = MapaTabela::getTabela($espacialidade);

        $this->foreign_key = MapaTabela::getChaveEstrangeira($contexto, $espacialidade);

        // país pega todos valores
        if ($contexto == ESP_PAIS)
        {
            $this->sql = "SELECT id FROM {$this->tabela}";
            return $this->sql;
        }
        else
        {
            $_id = implode(', ', $array_id);
            $this->sql = "SELECT id FROM {$this->tabela} WHERE {$this->foreign_key} IN ({$_id})";

            // RM verificar se está ativa
            if ($espacialidade == ESP_REGIAOMETROPOLITANA)
            {
                $this->sql .= " AND ativo=TRUE";
            }

            return $this->sql;
        }
    }

    /**
     * Adiciona mais IDs.
     *
     * @param string|int|array $id 	
     * @return array
     */
    public function addEspacialidade($id)
    {
        if (is_array($id) && !in_array(-1, $id))
        {
            $list_id = implode(', ', $id);

            if ($list_id)
            {
                $this->sql .= " OR id IN ($list_id)";
            }
        }

        if (ctype_digit((string) $id))
        {
            $this->sql .= " OR id IN ($list_id)";
        }

        if (in_array(-1, $id) || $id == -1)
        {
            $this->sql .= " OR id IN (SELECT id FROM {$this->tabela})";
        }
    }

    /**
     * Retorna uma sql formatada para 
     * gerenciamento de IDs de espacialidade diferente.
     * 
     * @return string
     */
    public function getSql()
    {
        return $this->sql;
    }

}
