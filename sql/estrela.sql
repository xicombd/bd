DROP TABLE IF EXISTS factos;
DROP TABLE IF EXISTS tempo;
DROP TABLE IF EXISTS localizacao;

CREATE TABLE tempo(
  tid 		INT AUTO_INCREMENT,
  ano 		INT NOT NULL,
  mes 		INT NOT NULL,
  dia 		INT NOT NULL,
  PRIMARY KEY (tid)
);

CREATE TABLE localizacao(
  locid 	INT AUTO_INCREMENT,
  regiao 	VARCHAR(80) NOT NULL,
  concelho 	VARCHAR(80) NOT NULL,
  PRIMARY KEY (locid)
);

CREATE TABLE factos(
  localizacao 	INT NOT NULL,
  tempo 	INT NOT NULL,
  leilao	INT,
  lancemax	INT NOT NULL,
  FOREIGN KEY (localizacao)  REFERENCES localizacao(locid),
  FOREIGN KEY (tempo)  REFERENCES tempo(tid),
  PRIMARY KEY (leilao)
);

INSERT INTO tempo(ano, mes, dia)
  SELECT DISTINCT YEAR(dia), MONTH(dia), DAY(dia)
  FROM leilaor;
  
INSERT INTO localizacao(regiao, concelho)
  SELECT DISTINCT regiao, concelho
  FROM leiloeira;

INSERT INTO factos(lancemax, tempo, localizacao, leilao)
  SELECT MAX(lance.valor), tempo.tid, localizacao.locid, lance.leilao
  FROM leilaor, lance, tempo, localizacao, leiloeira
  WHERE leilaor.lid = lance.leilao 
    AND leiloeira.regiao = localizacao.regiao 
    AND leiloeira.concelho = localizacao.concelho
    AND DAY(leilaor.dia) = tempo.dia
    AND MONTH(leilaor.dia) = tempo.mes
    AND YEAR(leilaor.dia) = tempo.ano
  GROUP BY lance.leilao;
  
SELECT concelho, mes, dia, SUM(lancemax)
  FROM factos, tempo, localizacao
  WHERE YEAR(dia) = 2012 OR YEAR(dia) = 2013
  GROUP BY concelho, mes, dia WITH ROLLUP;
  
  
 SELECT concelho, mes, dia, SUM(lancemax)
  FROM factos, tempo, localizacao
  GROUP BY concelho, mes, dia WITH ROLLUP;
  
/*  
INSERT INTO tempo(ano, mes, dia) VALUES
  (2014, 10, 1),
  (2014, 12, 2),
  (2014, 10, 3),
  (2014, 12, 4),
  (2014, 10, 5),
  (2014, 12, 6);
  
INSERT INTO localizacao(regiao, concelho) VALUES
  ("A", "aa"),
  ("B", "bb"),
  ("C", "cc");
  
  
*/