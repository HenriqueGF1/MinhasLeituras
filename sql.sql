CREATE TABLE usuario (
	id_usuario serial4 NOT NULL,
	nome varchar(40) NOT NULL,
	email varchar(100) NOT NULL,
	"password" text NOT NULL,
	data_nascimento date NOT NULL,    
	data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

COMMENT ON COLUMN usuario.id_usuario IS 'Identificador único do usuário';
COMMENT ON COLUMN usuario.nome IS 'Nome completo do usuário';
COMMENT ON COLUMN usuario.email IS 'Endereço de e-mail do usuário (único no sistema)';
COMMENT ON COLUMN usuario.password IS 'Senha criptografada do usuário';
COMMENT ON COLUMN usuario.data_nascimento IS 'Data de nascimento do usuário';
COMMENT ON COLUMN usuario.data_registro IS 'Data e hora em que o usuário foi cadastrado no sistema';

CREATE TABLE status_leitura (
    id_status_leitura SERIAL PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

COMMENT ON COLUMN status_leitura.id_status_leitura IS 'Identificador único do status da leitura';
COMMENT ON COLUMN status_leitura.descricao IS 'Descrição do status da leitura (Ex: Em andamento, Concluído)';
COMMENT ON COLUMN status_leitura.data_registro IS 'Data e hora em que o status foi cadastrado';

INSERT INTO public.status_leitura
(id_status_leitura, descricao, data_registro)
VALUES(nextval('status_leitura_id_status_leitura_seq'::regclass), 'Lido', now());

INSERT INTO public.status_leitura
(id_status_leitura, descricao, data_registro)
VALUES(nextval('status_leitura_id_status_leitura_seq'::regclass), 'Lendo', now());

INSERT INTO public.status_leitura
(id_status_leitura, descricao, data_registro)
VALUES(nextval('status_leitura_id_status_leitura_seq'::regclass), 'Pretendo Ler', now());

CREATE TABLE editora (
    id_editora SERIAL PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

COMMENT ON COLUMN editora.id_editora IS 'Identificador único da editora';
COMMENT ON COLUMN editora.descricao IS 'Nome da editora responsável pela publicação';
COMMENT ON COLUMN editora.data_registro IS 'Data e hora do registro da editora no sistema';

CREATE TABLE autor (
    id_autor SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

COMMENT ON COLUMN autor.id_autor IS 'Identificador único do autor';
COMMENT ON COLUMN autor.nome IS 'Nome do autor da obra';
COMMENT ON COLUMN autor.email IS 'E-mail de contato do autor';
COMMENT ON COLUMN autor.data_registro IS 'Data e hora em que o autor foi cadastrado';

CREATE TABLE genero (
    id_genero SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL
);

COMMENT ON COLUMN genero.id_genero IS 'Identificador único do gênero literário';
COMMENT ON COLUMN genero.nome IS 'Nome do gênero literário (Ex: Ficção, Romance, Terror)';
COMMENT ON COLUMN genero.data_registro IS 'Data e hora do registro do gênero';

INSERT INTO genero (nome, data_registro) VALUES 
('Ficção Científica', NOW()),
('Fantasia', NOW()),
('Romance', NOW()),
('Terror', NOW()),
('Mistério', NOW()),
('Thriller', NOW()),
('Drama', NOW()),
('Aventura', NOW()),
('História', NOW()),
('Biografia', NOW()),
('Autoajuda', NOW()),
('Psicologia', NOW()),
('Filosofia', NOW()),
('Poesia', NOW()),
('Contos', NOW()),
('Distopia', NOW()),
('Humor', NOW()),
('Religião', NOW()),
('Ficção Histórica', NOW()),
('Mangá', NOW());

CREATE TABLE leituras (
    id_leitura SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    capa VARCHAR(150) NOT NULL,
    id_editora INT NOT NULL, 
    id_autor INT NOT NULL, 
    ano_publicacao DATE NOT NULL, 
    qtd_capitulos INT NOT NULL CHECK (qtd_capitulos > 0),
    qtd_paginas INT NOT NULL CHECK (qtd_paginas > 0), 
    isbn VARCHAR(17) NOT NULL UNIQUE,
    data_inicio_leitura TIMESTAMP DEFAULT NOW() NOT NULL,
    id_status_leitura INT NOT NULL, 
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_status_leitura) REFERENCES status_leitura (id_status_leitura) ON DELETE SET NULL,
    FOREIGN KEY (id_editora) REFERENCES editora (id_editora) ON DELETE CASCADE,
    FOREIGN KEY (id_autor) REFERENCES autor (id_autor) ON DELETE CASCADE
);

COMMENT ON COLUMN leituras.id_leitura IS 'Identificador único da leitura';
COMMENT ON COLUMN leituras.titulo IS 'Título do livro ou material de leitura';
COMMENT ON COLUMN leituras.descricao IS 'Descrição geral do livro';
COMMENT ON COLUMN leituras.capa IS 'URL ou caminho da imagem da capa do livro';
COMMENT ON COLUMN leituras.id_editora IS 'Chave estrangeira referenciando a editora responsável';
COMMENT ON COLUMN leituras.id_autor IS 'Chave estrangeira referenciando o autor do livro';
COMMENT ON COLUMN leituras.ano_publicacao IS 'Ano de publicação do livro';
COMMENT ON COLUMN leituras.qtd_capitulos IS 'Quantidade de capítulos do livro';
COMMENT ON COLUMN leituras.qtd_paginas IS 'Quantidade total de páginas';
COMMENT ON COLUMN leituras.isbn IS 'Número ISBN do livro (código de identificação único)';
COMMENT ON COLUMN leituras.data_inicio_leitura IS 'Data de início da leitura';
COMMENT ON COLUMN leituras.id_status_leitura IS 'Chave estrangeira referenciando o status da leitura';
COMMENT ON COLUMN leituras.data_registro IS 'Data e hora do registro da leitura no sistema';

CREATE TABLE genero_leitura (
    id_genero_leitura SERIAL PRIMARY KEY,
    id_genero INT NOT NULL,
    id_leitura INT NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_genero) REFERENCES genero (id_genero) ON DELETE CASCADE,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE
);

COMMENT ON COLUMN genero_leitura.id_genero_leitura IS 'Identificador único da relação entre leitura e gênero';
COMMENT ON COLUMN genero_leitura.id_genero IS 'Chave estrangeira referenciando o gênero da leitura';
COMMENT ON COLUMN genero_leitura.id_leitura IS 'Chave estrangeira referenciando a leitura associada';
COMMENT ON COLUMN genero_leitura.data_registro IS 'Data e hora em que a associação foi criada';

CREATE TABLE favoritos (
    id_favoritos SERIAL PRIMARY KEY,
    id_leitura INT NOT NULL,
    id_usuario INT NOT NULL, -- Supondo que haja uma tabela de usuários
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

COMMENT ON COLUMN favoritos.id_favoritos IS 'Identificador único do registro de favorito';
COMMENT ON COLUMN favoritos.id_leitura IS 'Chave estrangeira referenciando a leitura favoritada';
COMMENT ON COLUMN favoritos.id_usuario IS 'Chave estrangeira referenciando o usuário que favoritou';
COMMENT ON COLUMN favoritos.data_registro IS 'Data e hora em que o favorito foi registrado';
