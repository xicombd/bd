
-- define como terminador de comandos o caracter ;
DELIMITER ;

-- desativa a verificaçõ das chaves estrangeiras
SET foreign_key_checks = 0 ;

-- tabela das pessoas 
DROP TABLE IF EXISTS pessoa ;
CREATE TABLE pessoa( 
	nif 			INT ,    					-- ID e username das pessoas pessoa
	nome  			VARCHAR(80) NOT NULL,			
	pin     		INT NOT NULL, 	 			-- codigo de acesso desta pessoa (pin ou passwd)
	PRIMARY KEY (nif)
);

-- tabela das pessoas coletivas 
DROP TABLE IF EXISTS pessoac;
CREATE TABLE pessoac( 
	nif 			INT, 
	capitalsocial 	INT NOT NULL,
	PRIMARY KEY (nif),
	FOREIGN KEY (nif)  REFERENCES pessoa(nif)
);

-- tabela das leiloeiras 
DROP TABLE IF EXISTS leiloeira;
CREATE TABLE leiloeira( 
	nif 			INT, 
	nralvara 		INT NOT NULL,
	concelho 		VARCHAR (80) NULL,
	regiao 			VARCHAR (80) NULL,
	PRIMARY KEY (nif),
	FOREIGN KEY (nif)  REFERENCES pessoac(nif)
);

-- tabela dos leilões
DROP TABLE IF EXISTS leilao;
CREATE TABLE leilao( 
	dia				DATE, 		-- dia  em que o leilão se realiza
	nrleilaonodia	INT ,      		-- Contador diarios de leilões: vale 1 para o 1º leilão do dia, 2 para o 2º leilão do dia etc.
	nif 			INT , 
	nome   		 	VARCHAR (80) NULL, 	-- Nome (da área de concessão do recurso ou da área de exploração de infraestrutura) a ser leiloada neste leilão
	valorbase		INT NOT NULL, 		-- Valor de base do leião.
	tipo			BOOLEAN NOT NULL,	-- Tipo de leilão .
											-- TRUE = leilao de área de concessão de recursos, 
											-- FALSE = leilao de area de exploracao de infraestrutura
	PRIMARY KEY (nif,dia,nrleilaonodia),
	FOREIGN KEY (nif)  REFERENCES leiloeira(nif)
);

-- tabela dos leilões de Recursos 
DROP TABLE IF EXISTS leilaor;
CREATE TABLE leilaor( 
	dia					DATE NOT NULL,		-- dia em que po leilão abre (desde a hora 00:00:00) 
	nrleilaonodia		INT NOT NULL,
	nif 				INT NOT NULL, 	
	nrdias				INT NOT NULL, 		-- nr de dias em que  leilão está aberto
	lid					INT AUTO_INCREMENT, 
	FOREIGN KEY (nif,dia,nrleilaonodia)  REFERENCES leilao(nif,dia,nrleilaonodia),
	PRIMARY KEY (nif,dia,nrleilaonodia),
	UNIQUE KEY(lid)
);

-- tabela com os  concorrentes registados aos leilões de Recursos 
DROP TABLE IF EXISTS concorrente;
CREATE TABLE concorrente( 
	pessoa				INT NOT NULL, 
	leilao 				INT NOT NULL, 	
	PRIMARY KEY (pessoa,leilao),
	FOREIGN KEY (pessoa)  REFERENCES pessoa(nif),
	FOREIGN KEY (leilao)  REFERENCES leilaor(lid)
);

-- tabela com os lances dos concorrentes aos  leilões de Recursos 
DROP TABLE IF EXISTS lance;
CREATE TABLE lance( 
	pessoa				INT NOT NULL, 
	leilao 				INT NOT NULL,
	valor 				INT NOT NULL, 	-- valor de cada lance 
	PRIMARY KEY (pessoa,leilao,valor),
	FOREIGN KEY (pessoa,leilao)  REFERENCES concorrente(pessoa,leilao)
);

-- ativa a verificaçõ das chaves estrangeiras
SET foreign_key_checks = 1 ;

