CREATE TABLE usuario (
    id_usuario SERIAL PRIMARY KEY,
    nome VARCHAR(40) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,  
    senha TEXT NOT NULL,                 
    data_nascimento DATE NOT NULL,       
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

INSERT INTO usuario (nome,email,senha,data_nascimento,data_registro)
VALUES ('Henrique','henrique@gmail.com','123',NOW(),NOW());

SELECT * FROM usuario u 