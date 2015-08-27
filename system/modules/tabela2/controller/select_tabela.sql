SELECT
	*
FROM crosstab (
		'SELECT
			trim(e.nome) as nome,
			vve.fk_variavel || $$ $$ || fk_ano_referencia AS var,
			vve.valor
		FROM
			valor_variavel_estado vve
		INNER JOIN estado e ON vve.fk_estado = e.id
		INNER JOIN variavel v ON vve.fk_variavel = v.id
		INNER JOIN ano_referencia ar ON vve.fk_ano_referencia = ar.id
		WHERE
			(
				(vve.fk_variavel = 196 AND vve.fk_ano_referencia = 2) OR
				(vve.fk_variavel = 196 AND vve.fk_ano_referencia = 3) OR
				(vve.fk_variavel = 197 AND vve.fk_ano_referencia = 2)
			) AND
			vve.fk_estado IN (1,2,3,4)
		ORDER BY 1, var'
) as ct(
	nome text,
	"IDHM 2000" numeric,
	"IDHM 2010" numeric,
	"IDHM_R 2000" numeric
	)			