<?php

/**
 * Regras para determinadas situações.
 * 
 * @see Constantes.php
 * @see init.php
 * @package map
 * @author AtlasBrasil
 */
class RulesFactoryEspacialidadeDao {

    /**
     * Retorna um array com todos as configurações para criação do DAO 
     * da espacialidade referente.
     * 
     * @return array
     */
    public static function getRules() {
        switch (strtoupper(RULES_MAP_TYPE)) {
            case 'JSON':
                $json_file = file_get_contents(RULES_MAP_FILE);
                $json = json_decode($json_file, true);
                return $json;

            case 'XML':
                $xml = simplexml_load_file(RULES_MAP_FILE);
                return $xml;

            case 'PHP':
                return (include_once RULES_MAP_FILE);

            default:
                throw new Exception("Erro de fabricação de objeto: RulesFactoryDao");
        }
    }

}
