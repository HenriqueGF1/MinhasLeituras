
CREATE TABLE usuario (
	id_usuario SERIAL PRIMARY KEY,
	nome VARCHAR(40) NOT NULL,
	email VARCHAR(100) NOT NULL,
	"password" VARCHAR(255) NOT NULL,
	data_nascimento DATE NOT NULL,    
	data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
	UNIQUE (email)
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
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    UNIQUE (descricao)
);

COMMENT ON COLUMN status_leitura.id_status_leitura IS 'Identificador único do status da leitura';
COMMENT ON COLUMN status_leitura.descricao IS 'Descrição do status da leitura (Ex: Em andamento, Concluído) (único no sistema)';
COMMENT ON COLUMN status_leitura.data_registro IS 'Data e hora em que o status foi cadastrado';

INSERT INTO status_leitura (descricao, data_registro) VALUES 
('Lido', NOW()),
('Lendo', NOW()),
('Pretendo Ler', NOW());

CREATE TABLE editora (
    id_editora SERIAL PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    UNIQUE (descricao)
);

COMMENT ON COLUMN editora.id_editora IS 'Identificador único da editora';
COMMENT ON COLUMN editora.descricao IS 'Nome da editora responsável pela publicação (único no sistema)';
COMMENT ON COLUMN editora.data_registro IS 'Data e hora do registro da editora no sistema';

CREATE TABLE autor (
    id_autor SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    UNIQUE (nome)
);

COMMENT ON COLUMN autor.id_autor IS 'Identificador único do autor';
COMMENT ON COLUMN autor.nome IS 'Nome do autor da obra (único no sistema)';
COMMENT ON COLUMN autor.data_registro IS 'Data e hora em que o autor foi cadastrado';

CREATE TABLE genero (
    id_genero SERIAL PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    UNIQUE (nome)
);

COMMENT ON COLUMN genero.id_genero IS 'Identificador único do gênero literário';
COMMENT ON COLUMN genero.nome IS 'Nome do gênero literário (Ex: Ficção, Romance, Terror) (único no sistema)';
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
    data_publicacao DATE NOT NULL, 
    qtd_capitulos INT NOT NULL,
    qtd_paginas INT NOT NULL CHECK (qtd_paginas > 0), 
    isbn VARCHAR(17) NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_editora) REFERENCES editora (id_editora) ON DELETE CASCADE,
    FOREIGN KEY (id_autor) REFERENCES autor (id_autor) ON DELETE CASCADE,
    UNIQUE (isbn)
);

COMMENT ON COLUMN leituras.id_leitura IS 'Identificador único da leitura';
COMMENT ON COLUMN leituras.titulo IS 'Título do livro ou material de leitura';
COMMENT ON COLUMN leituras.descricao IS 'Descrição geral do livro';
COMMENT ON COLUMN leituras.capa IS 'URL ou caminho da imagem da capa do livro';
COMMENT ON COLUMN leituras.id_editora IS 'Chave estrangeira referenciando a editora responsável';
COMMENT ON COLUMN leituras.id_autor IS 'Chave estrangeira referenciando o autor do livro';
COMMENT ON COLUMN leituras.data_publicacao IS 'Data de publicação do livro';
COMMENT ON COLUMN leituras.qtd_capitulos IS 'Quantidade de capítulos do livro';
COMMENT ON COLUMN leituras.qtd_paginas IS 'Quantidade total de páginas';
COMMENT ON COLUMN leituras.isbn IS 'Número ISBN do livro (código de identificação único)';

CREATE TABLE usuario_leituras (
    id_usuario_leitura SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_leitura INT NOT NULL,
    id_status_leitura INT,
    qtd_paginas_lidas INT,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE,
    FOREIGN KEY (id_status_leitura) REFERENCES status_leitura (id_status_leitura) ON DELETE SET NULL,
    UNIQUE (id_usuario, id_leitura)
);

COMMENT ON TABLE usuario_leituras IS 'Tabela que registra a relação entre usuários e leituras, incluindo o status da leitura.';

-- Comentários para a tabela usuario_leituras
COMMENT ON COLUMN usuario_leituras.id_usuario_leitura IS 'Identificador único da relação entre usuário e leitura.';
COMMENT ON COLUMN usuario_leituras.id_usuario IS 'Identificador do usuário que realizou a leitura.';
COMMENT ON COLUMN usuario_leituras.id_leitura IS 'Identificador da leitura associada ao usuário.';
COMMENT ON COLUMN usuario_leituras.id_status_leitura IS 'Status da leitura (exemplo: concluída, em andamento, etc.).';
COMMENT ON COLUMN usuario_leituras.qtd_paginas_lidas IS 'Armazena a quantidade de paginas lidas pelo usuario.';
COMMENT ON COLUMN usuario_leituras.data_registro IS 'Data e hora do registro da relação entre usuário e leitura.';

CREATE TABLE genero_leitura (
    id_genero_leitura SERIAL PRIMARY KEY,
    id_genero INT NOT NULL,
    id_leitura INT NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_genero) REFERENCES genero (id_genero) ON DELETE CASCADE,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE,
    UNIQUE (id_genero, id_leitura)
);

COMMENT ON TABLE genero_leitura IS 'Tabela que vincula leituras aos gêneros literários correspondentes.';

-- Comentários para a tabela genero_leitura
COMMENT ON COLUMN genero_leitura.id_genero_leitura IS 'Identificador único do vínculo entre gênero e leitura.';
COMMENT ON COLUMN genero_leitura.id_genero IS 'Identificador do gênero literário associado à leitura.';
COMMENT ON COLUMN genero_leitura.id_leitura IS 'Identificador da leitura vinculada ao gênero.';
COMMENT ON COLUMN genero_leitura.data_registro IS 'Data e hora do registro do vínculo entre leitura e gênero.';

CREATE TABLE leitura_progresso (
    id_leitura_progresso SERIAL PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_leitura INTEGER NOT NULL,
    qtd_paginas_lidas INTEGER NOT NULL CHECK (qtd_paginas_lidas > 0),
    data_leitura DATE NOT NULL,
	data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE
);

-- Comentário geral da tabela
COMMENT ON TABLE leitura_progresso IS 'Registra o progresso diário de leitura dos usuários, associando cada leitura a um número de páginas lidas em uma data específica.';

-- Comentários nas colunas
COMMENT ON COLUMN leitura_progresso.id_leitura_progresso IS 'Identificador único do registro de progresso de leitura.';
COMMENT ON COLUMN leitura_progresso.id_usuario IS 'Referência ao usuário que realizou a leitura.';
COMMENT ON COLUMN leitura_progresso.id_leitura IS 'Referência à leitura em andamento, vinculada à tabela de leituras.';
COMMENT ON COLUMN leitura_progresso.qtd_paginas_lidas IS 'Quantidade de páginas lidas pelo usuário na data especificada.';
COMMENT ON COLUMN leitura_progresso.data_leitura IS 'Data em que a leitura foi realizada.';
COMMENT ON COLUMN leitura_progresso.data_registro IS 'Timestamp automático do momento em que o registro foi inserido na base de dados.';

CREATE TABLE favoritos (
    id_favoritos SERIAL PRIMARY KEY,
    id_leitura INT NOT NULL,
    id_usuario INT NOT NULL,
    data_registro TIMESTAMP DEFAULT NOW() NOT NULL,
    FOREIGN KEY (id_leitura) REFERENCES leituras (id_leitura) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario) ON DELETE CASCADE,
    UNIQUE (id_leitura, id_usuario)
);

COMMENT ON TABLE favoritos IS 'Tabela que armazena as leituras marcadas como favoritas pelos usuários.';

-- Comentários para a tabela favoritos
COMMENT ON COLUMN favoritos.id_favoritos IS 'Identificador único da marcação de leitura como favorita.';
COMMENT ON COLUMN favoritos.id_leitura IS 'Identificador da leitura marcada como favorita.';
COMMENT ON COLUMN favoritos.id_usuario IS 'Identificador do usuário que marcou a leitura como favorita.';
COMMENT ON COLUMN favoritos.data_registro IS 'Data e hora do registro da leitura como favorita pelo usuário.';
