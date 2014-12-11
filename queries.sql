//QUERIES

//ex1

SELECT C.pessoa
FROM concorrente C
WHERE C.pessoa NOT IN
(
  SELECT L.pessoa
  FROM lance L
);

//ex2
SELECT nome
FROM pessoa, pessoac, concorrente
WHERE pessoac.nif = concorrente.pessoa AND pessoac.nif = pessoa.nif
GROUP BY pessoa.nome
HAVING COUNT(*) = 2;

//ex3
SELECT dia, nif, nrleilaonodia, MAX(maxvalor/valorbase) as ratio
FROM (
  SELECT leilao.dia, leilao.nif, leilao.nrleilaonodia, MAX(lance.valor) as maxvalor, valorbase
  FROM leilao, lance, leilaor
  WHERE lance.leilao = leilaor.lid
  AND leilao.nif = leilaor.nif AND leilao.dia = leilaor.dia AND leilao.nrleilaonodia = leilaor.nrleilaonodia
  GROUP BY leilaor.lid
) as tabela;

//ex4
SELECT DISTINCT pessoa.nome, p1.nif, p1.capitalsocial
FROM pessoac as p1, pessoac as p2, pessoa
WHERE p1.capitalsocial = p2.capitalsocial AND p1.nif != p2.nif AND pessoa.nif = p1.nif
ORDER BY capitalsocial;



//TRIGGERS

//ex1
delimiter //
CREATE TRIGGER lance_base BEFORE INSERT ON lance
FOR EACH ROW
BEGIN
  IF NEW.valor < (SELECT valorbase
		  FROM leilao, leilaor
		  WHERE NEW.leilao = leilaor.lid
		    AND leilaor.nif = leilao.nif
		    AND leilaor.dia = leilao.dia
		    AND leilaor.nrleilaonodia = leilao.nrleilaonodia)
  THEN
    CALL lance_deve_ser_maior_que_base();
  END IF;
END //
delimiter ;


//ex2
delimiter //
CREATE TRIGGER lance_crescente BEFORE INSERT ON lance
FOR EACH ROW
BEGIN
IF NEW.valor <= ANY(SELECT valor
FROM lance
WHERE 40 = lance.leilao)
  THEN
    CALL lance_deve_ser_crescente();
  END IF;
END //
delimiter ;


//indices
//ex3
Como todas as operações feitas nesta query são feitas sobre chaves primárias ou únicas, não é necessário criar índices extra, sendo usados apenas os pré-definidos pelo MySQL

//ex4
CREATE INDEX IndexCS on pessoac(capitalsocial) USING BTREE;