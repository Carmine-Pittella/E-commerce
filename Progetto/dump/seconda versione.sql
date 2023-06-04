-- in questa versione si assume che Prodotto può avere più di un colore e più di una categoria
-- avremmo anche risolto il problema del MINIMO 18 tabelle SQL. così facendo ne abbiamo 19 e ne possiamo
-- sfanculare una a piacimento

DROP TABLE IF EXISTS Colore_Prodotto;
DROP TABLE IF EXISTS Categoria_Prodotto;


CREATE TABLE IF NOT EXISTS Colore (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_colore VARCHAR(50) NOT NULL,
    codice_colore VARCHAR(6) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_categoria VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Prodotto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_prodotto VARCHAR(100) NOT NULL,
    descrizione VARCHAR(500),
    prezzo DECIMAL(10, 2) NOT NULL,
    quantità_disponibile INT NOT NULL DEFAULT 0,
    -- id_colore INT NOT NULL,
    -- id_categoria INT NOT NULL,
    id_marca INT,
    id_promozione INT,
    -- FOREIGN KEY (id_colore) REFERENCES Colore(id),
    -- FOREIGN KEY (id_categoria) REFERENCES Categoria(id),
    FOREIGN KEY (id_marca) REFERENCES Marca(id),
    FOREIGN KEY (id_promozione) REFERENCES Promozione(id)
);


-------------------------------- MODIFICHE AGGIUNTIVE --------------------------------

CREATE TABLE IF NOT EXISTS Colore_Prodotto (
    id INT PRIMARY KEY AUTO_INCREMENT, -- si potrebbe fare anche a meno dell'ID
    id_prodotto INT NOT NULL,
    id_colore INT NOT NULL,
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id),
    FOREIGN KEY (id_colore) REFERENCES Colore(id),
    UNIQUE (id_prodotto, id_colore),
);

CREATE TABLE IF NOT EXISTS Categoria_Prodotto (
    id INT PRIMARY KEY AUTO_INCREMENT, -- si potrebbe fare anche a meno dell'ID
    id_prodotto INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id),
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id),
    UNIQUE (id_prodotto, id_categoria),
);