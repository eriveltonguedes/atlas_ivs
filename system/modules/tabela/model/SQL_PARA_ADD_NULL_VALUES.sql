-- Estado
CREATE TEMP TABLE temp1 AS
SELECT
	variavel.id as variavel,
	estado.id as estado,
	ano_referencia.id as ano
FROM
	variavel, estado, ano_referencia;

INSERT INTO valor_variavel_estado(fk_estado, fk_variavel, fk_ano_referencia, valor)
SELECT
	estado, variavel, ano, NULL as valor
FROM
	temp1 t
LEFT JOIN valor_variavel_estado v ON t.estado = v.fk_estado AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_estado IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp1;

-- Município
CREATE TEMP TABLE temp2 AS
SELECT
	variavel.id as variavel,
	municipio.id as municipio,
	ano_referencia.id as ano
FROM
	variavel, municipio, ano_referencia;
	
INSERT INTO valor_variavel_mun(fk_municipio, fk_variavel, fk_ano_referencia, valor)
SELECT
	municipio, variavel, ano, NULL as valor
FROM
	temp2 t
LEFT JOIN valor_variavel_mun v ON t.municipio = v.fk_municipio AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_municipio IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp2;

-- PAIS
CREATE TEMP TABLE temp3 AS
SELECT
	variavel.id as variavel,
	pais.id as pais,
	ano_referencia.id as ano
FROM
	variavel, pais, ano_referencia;

INSERT INTO valor_variavel_pais(fk_pais, fk_variavel, fk_ano_referencia, valor)
SELECT
	pais, variavel, ano, NULL as valor
FROM
	temp3 t
LEFT JOIN valor_variavel_pais v ON t.pais = v.fk_pais AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_pais IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp3;

-- REGIAO
CREATE TEMP TABLE temp4 AS
SELECT
	variavel.id as variavel,
	regiao.id as regiao,
	ano_referencia.id as ano
FROM
	variavel, regiao, ano_referencia;

INSERT INTO valor_variavel_regiao(fk_regiao, fk_variavel, fk_ano_referencia, valor)
SELECT
	regiao, variavel, ano, NULL as valor
FROM
	temp4 t
LEFT JOIN valor_variavel_regiao v ON t.regiao = v.fk_regiao AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_regiao IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp4;

--REGIONAL
CREATE TEMP TABLE temp5 AS
SELECT
	variavel.id as variavel,
	regional.id as regional,
	ano_referencia.id as ano
FROM
	variavel, regional, ano_referencia;

INSERT INTO valor_variavel_regional(fk_regional, fk_variavel, fk_ano_referencia, valor)
SELECT
	regional, variavel, ano, NULL as valor
FROM
	temp5 t
LEFT JOIN valor_variavel_regional v ON t.regional = v.fk_regional AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_regional IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp5;

-- REGIAO INTERESSE
CREATE TEMP TABLE temp6 AS
SELECT
	variavel.id as variavel,
	regiao_interesse.id as regiao_interesse,
	ano_referencia.id as ano
FROM
	variavel, regiao_interesse, ano_referencia;

INSERT INTO valor_variavel_ri(fk_regiao_interesse, fk_variavel, fk_ano_referencia, valor)
SELECT
	regiao_interesse, variavel, ano, NULL as valor
FROM
	temp6 t
LEFT JOIN valor_variavel_ri v ON t.regiao_interesse = v.fk_regiao_interesse AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_regiao_interesse IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp6;

-- RM
CREATE TEMP TABLE temp7 AS
SELECT
	variavel.id as variavel,
	rm.id as rm,
	ano_referencia.id as ano
FROM
	variavel, rm, ano_referencia;

INSERT INTO valor_variavel_rm(fk_rm, fk_variavel, fk_ano_referencia, valor)
SELECT
	rm, variavel, ano, NULL as valor
FROM
	temp7 t
LEFT JOIN valor_variavel_rm v ON t.rm = v.fk_rm AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_rm IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp7;

--UDH
CREATE TEMP TABLE temp8 AS
SELECT
	variavel.id as variavel,
	rm.id as rm,
	ano_referencia.id as ano
FROM
	variavel, rm, ano_referencia;

INSERT INTO valor_variavel_rm(fk_rm, fk_variavel, fk_ano_referencia, valor)
SELECT
	rm, variavel, ano, NULL as valor
FROM
	temp8 t
LEFT JOIN valor_variavel_rm v ON t.rm = v.fk_rm AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_rm IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp8;

-- UDH
CREATE TEMP TABLE temp9 AS
SELECT
	variavel.id as variavel,
	udh.id as udh,
	ano_referencia.id as ano
FROM
	variavel, udh, ano_referencia;

INSERT INTO valor_variavel_udh(fk_udh, fk_variavel, fk_ano_referencia, valor)
SELECT
	udh, variavel, ano, NULL as valor
FROM
	temp9 t
LEFT JOIN valor_variavel_udh v ON t.udh = v.fk_udh AND t.ano = v.fk_ano_referencia AND t.variavel = v.fk_variavel
WHERE
	v.fk_udh IS NULL AND v.fk_ano_referencia IS NULL AND v.fk_variavel IS NULL AND t.ano <> 4;

DROP TABLE temp9;
