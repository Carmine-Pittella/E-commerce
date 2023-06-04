--
-- Database: `ecommerce`
--
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Drop Tabelle
DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Prodotto;
DROP TABLE IF EXISTS Colore;
DROP TABLE IF EXISTS Categoria;
DROP TABLE IF EXISTS Marca;
DROP TABLE IF EXISTS Promozione;
DROP TABLE IF EXISTS Prodotto_Preferito;
DROP TABLE IF EXISTS Ordine;
DROP TABLE IF EXISTS Oggetto_Ordine;
DROP TABLE IF EXISTS Carrello;
DROP TABLE IF EXISTS Oggetto_Carrello;
DROP TABLE IF EXISTS Indirizzo_Spedizione;
DROP TABLE IF EXISTS Recensione;
DROP TABLE IF EXISTS Coupon;
DROP TABLE IF EXISTS Messaggio;
DROP TABLE IF EXISTS Immagine_Prodotto;
DROP TABLE IF EXISTS Metodo_Pagamento;


-- --------------------------------  CREAZIONE TABELLE ----------------------------------

CREATE TABLE IF NOT EXISTS Utente (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    cognome VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    tipologia_utente ENUM('admin', 'comune') DEFAULT 'comune'
);

CREATE TABLE IF NOT EXISTS Colore (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_colore VARCHAR(50) NOT NULL,
    codice_colore VARCHAR(6) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Categoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_categoria VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Marca (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_marca VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS Promozione (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_promozione VARCHAR(100) NOT NULL,
    descrizione VARCHAR(500),
    sconto_percentuale DECIMAL(5, 2) NOT NULL,
    data_inizio DATE NOT NULL,
    data_fine DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS Prodotto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_prodotto VARCHAR(100) NOT NULL,
    descrizione VARCHAR(500),
    prezzo DECIMAL(10, 2) NOT NULL,
    quantità_disponibile INT NOT NULL DEFAULT 0,
    id_colore INT NOT NULL,
    id_categoria INT NOT NULL,
    id_marca INT,
    id_promozione INT,
    FOREIGN KEY (id_colore) REFERENCES Colore(id),
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id),
    FOREIGN KEY (id_marca) REFERENCES Marca(id),
    FOREIGN KEY (id_promozione) REFERENCES Promozione(id)
);

CREATE TABLE IF NOT EXISTS Prodotto_Preferito (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT,
    id_prodotto INT,
    FOREIGN KEY (id_utente) REFERENCES Utente(id),
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id),
    UNIQUE (id_utente, id_prodotto)
);

CREATE TABLE IF NOT EXISTS Ordine (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    data_ordine DATE NOT NULL,
    data_spedizione DATE NOT NULL,
    prezzo_ordine DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id)
);

CREATE TABLE IF NOT EXISTS Oggetto_Ordine (
    id_ordine INT NOT NULL,
    id_prodotto INT NOT NULL,
    quantita_prodotto INT NOT NULL,
    FOREIGN KEY (id_ordine) REFERENCES Ordine(id),
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id)
);

CREATE TABLE IF NOT EXISTS Carrello (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id)
);

CREATE TABLE IF NOT EXISTS Oggetto_Carrello (
    id_carrello INT NOT NULL,
    id_prodotto INT NOT NULL,
    quantita_prodotto INT NOT NULL,
    FOREIGN KEY (id_carrello) REFERENCES Carrello(id),
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id)
);

CREATE TABLE IF NOT EXISTS Indirizzo_Spedizione (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    indirizzo VARCHAR(200) NOT NULL,
    città VARCHAR(100) NOT NULL,
    CAP VARCHAR(10) NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id)
);

CREATE TABLE IF NOT EXISTS Recensione (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT NOT NULL,
    id_prodotto INT NOT NULL,
    testo_recensione TEXT(500),
    valutazione INT NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id),
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id)
);

CREATE TABLE IF NOT EXISTS Coupon (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codice_coupon VARCHAR(50) NOT NULL,
    sconto_percentuale DECIMAL(5, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS Messaggio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_utente INT,
    testo_messaggio VARCHAR(500),
    data_messaggio DATE NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utente(id)
);

CREATE TABLE IF NOT EXISTS Immagine_Prodotto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_prodotto INT NOT NULL, 
    url_immagine VARCHAR(200) NOT NULL,
    FOREIGN KEY (id_prodotto) REFERENCES Prodotto(id)
);

CREATE TABLE IF NOT EXISTS Metodo_Pagamento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_pagamento VARCHAR(100) UNIQUE,
    dettagli_pagamento VARCHAR(200)
);


-- --------------------------------  TRIGGER ----------------------------------









-- --------------------------------  PROCEDURE ----------------------------------











-- --------------------------------  INSERIMENTO DATI ----------------------------------

-- Inserimento valori casuali nella tabella Utente
INSERT INTO Utente (nome, cognome, email, password, tipologia_utente)
VALUES
    ('John', 'Doe', 'johndoe@example.com', 'password123', 'common'),
    ('Jane', 'Smith', 'janesmith@example.com', 'test456', 'common'),
    ('Admin', 'User', 'admin@example.com', 'adminpass', 'admin'),
    ('Alice', 'Johnson', 'alicejohnson@example.com', 'alicepass', 'common'),
    ('Bob', 'Williams', 'bobwilliams@example.com', 'bob123', 'common');

    -- Inserimento valori casuali nella tabella Colore
INSERT INTO Colore (nome_colore, codice_colore)
VALUES
    ('Rosso', 'FF0000'),
    ('Verde', '00FF00'),
    ('Blu', '0000FF'),
    ('Giallo', 'FFFF00'),
    ('Nero', '000000');

-- Inserimento valori casuali nella tabella Categoria
INSERT INTO Categoria (nome_categoria)
VALUES
    ('Categoria 1'),
    ('Categoria 2'),
    ('Categoria 3'),
    ('Categoria 4'),
    ('Categoria 5');

-- Inserimento valori casuali nella tabella Marca
INSERT INTO Marca (nome_marca)
VALUES
    ('Marca 1'),
    ('Marca 2'),
    ('Marca 3'),
    ('Marca 4'),
    ('Marca 5');

-- Inserimento valori casuali nella tabella Promozione
INSERT INTO Promozione (nome_promozione, descrizione, sconto_percentuale, data_inizio, data_fine)
VALUES
    ('Promozione 1', 'Descrizione promozione 1', 10.00, '2023-06-01', '2023-06-30'),
    ('Promozione 2', 'Descrizione promozione 2', 15.00, '2023-07-01', '2023-07-31'),
    ('Promozione 3', 'Descrizione promozione 3', 20.00, '2023-08-01', '2023-08-31'),
    ('Promozione 4', 'Descrizione promozione 4', 25.00, '2023-09-01', '2023-09-30'),
    ('Promozione 5', 'Descrizione promozione 5', 30.00, '2023-10-01', '2023-10-31');

-- Inserimento valori casuali nella tabella Prodotto
INSERT INTO Prodotto (nome_prodotto, descrizione, prezzo, quantità_disponibile, id_colore, id_categoria, id_marca, id_promozione)
VALUES
    ('Prodotto 1', 'Descrizione prodotto 1', 19.99, 10, 1, 1, 1, NULL),
    ('Prodotto 2', 'Descrizione prodotto 2', 29.99, 5, 2, 1, 2, NULL),
    ('Prodotto 3', 'Descrizione prodotto 3', 9.99, 20, 3, 2, 3, NULL),
    ('Prodotto 4', 'Descrizione prodotto 4', 14.99, 15, 1, 3, 1, NULL),
    ('Prodotto 5', 'Descrizione prodotto 5', 39.99, 8, 2, 3, 2, NULL);

-- Inserimento valori casuali nella tabella Prodotto_Preferito
INSERT INTO Prodotto_Preferito (id_utente, id_prodotto)
VALUES
    (1, 1),
    (2, 3),
    (3, 2),
    (4, 4),
    (5, 5);

-- Inserimento valori casuali nella tabella Ordine
INSERT INTO Ordine (id_utente, data_ordine, data_spedizione, prezzo_ordine)
VALUES
    (1, '2023-06-01', '2023-06-05', 39.99),
    (2, '2023-06-02', '2023-06-06', 59.98),
    (3, '2023-06-03', '2023-06-07', 19.99),
    (4, '2023-06-04', '2023-06-08', 29.99),
    (5, '2023-06-05', '2023-06-09', 79.98);

-- Inserimento valori casuali nella tabella Oggetto_Ordine
INSERT INTO Oggetto_Ordine (id_ordine, id_prodotto, quantita_prodotto)
VALUES
    (1, 1, 2),
    (2, 3, 1),
    (3, 2, 3),
    (4, 4, 2),
    (5, 5, 1);

-- Inserimento valori casuali nella tabella Carrello
INSERT INTO Carrello (id_utente)
VALUES
    (1),
    (2),
    (3),
    (4),
    (5);

-- Inserimento valori casuali nella tabella Oggetto_Carrello
INSERT INTO Oggetto_Carrello (id_carrello, id_prodotto, quantita_prodotto)
VALUES
    (1, 2, 1),
    (2, 3, 2),
    (3, 1, 3),
    (4, 4, 1),
    (5, 5, 2);

-- Inserimento valori casuali nella tabella Indirizzo_Spedizione
INSERT INTO Indirizzo_Spedizione (id_utente, indirizzo, città, CAP)
VALUES
    (1, 'Via Roma 1', 'Roma', '00100'),
    (2, 'Via Milano 2', 'Milano', '20100'),
    (3, 'Via Napoli 3', 'Napoli', '80100'),
    (4, 'Via Firenze 4', 'Firenze', '50100'),
    (5, 'Via Venezia 5', 'Venezia', '30100');

-- Inserimento valori casuali nella tabella Recensione
INSERT INTO Recensione (id_utente, id_prodotto, testo_recensione, valutazione)
VALUES
    (1, 1, 'Ottimo prodotto!', 5),
    (2, 3, 'Molto soddisfatto dell`acquisto.', 4),
    (3, 2, 'Buon rapporto qualità-prezzo.', 4),
    (4, 4, 'Consigliato!', 5),
    (5, 5, 'Prodotto di alta qualità.', 5);

-- Inserimento valori casuali nella tabella Coupon
INSERT INTO Coupon (codice_coupon, sconto_percentuale)
VALUES
    ('COUPON1', 10.00),
    ('COUPON2', 15.00),
    ('COUPON3', 20.00),
    ('COUPON4', 25.00),
    ('COUPON5', 30.00);

-- Inserimento valori casuali nella tabella Messaggio
INSERT INTO Messaggio (id_utente, testo_messaggio, data_messaggio)
VALUES
    (1, 'Ciao, ho bisogno di assistenza.', '2023-06-01'),
    (2, 'Grazie per l`ottimo servizio!', '2023-06-02'),
    (3, 'Quando sarà disponibile nuovamente il prodotto?', '2023-06-03'),
    (4, 'Ho un problema con il mio ordine.', '2023-06-04'),
    (5, 'Complimenti per la velocità di spedizione!', '2023-06-05');

-- Inserimento valori casuali nella tabella Immagine_Prodotto
INSERT INTO Immagine_Prodotto (id_prodotto, url_immagine)
VALUES
    (1, 'http://example.com/prodotto1.jpg'),
    (2, 'http://example.com/prodotto2.jpg'),
    (3, 'http://example.com/prodotto3.jpg'),
    (4, 'http://example.com/prodotto4.jpg'),
    (5, 'http://example.com/prodotto5.jpg');

-- Inserimento valori casuali nella tabella Metodo_Pagamento
INSERT INTO Metodo_Pagamento (tipo_pagamento, dettagli_pagamento)
VALUES
    ('Carta di credito', 'dettagli Carta di credito'),
    ('PayPal', 'dettagli PayPal'),
    ('Bonifico bancario', 'dettagli Bonifico bancario'),
    ('Contrassegno', 'dettagli Contrassegno'),
    ('Buono regalo', 'dettagli Buono regalo');
