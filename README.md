# TODO

Fazer as validacoes de leituras ja cadastradas
e os outros dados que devem ser unicos no banco de dados


# Gerenciamento de Leituras

Este projeto é uma aplicação de **gerenciamento de leituras** onde os usuários podem cadastrar, organizar e acompanhar seu progresso de leitura de livros, HQs e outros materiais. O sistema permite que os usuários gerenciem suas leituras, definam metas, escrevam avaliações, recebam lembretes para ler, e muito mais.

## Funcionalidades

- **Cadastro de Usuário**: Usuários podem criar uma conta fornecendo nome, email, senha e data de nascimento. O cadastro gera um token JWT para autenticação.
- **Login de Usuário**: Permite que os usuários se autentiquem com suas credenciais (nome e senha) utilizando um token JWT.
- **Cadastro de Livros, HQs, etc.**: Usuários podem cadastrar livros e materiais de leitura com informações como título, descrição, capa, editora, autor, quantidade de páginas, ISBN e status de leitura (Lendo, Lido, Gostaria de Ler). O sistema calcula o prazo estimado de leitura com base no número de páginas.
- **Edição e Exclusão de Livros**: Permite editar ou excluir os livros já cadastrados.
- **Progresso de Leitura**: O sistema permite que os usuários registrem o número de páginas lidas por dia, recalculando automaticamente o prazo de leitura. Quando o livro é completado, o status é alterado para "Lido".
- **Avaliações de Livros**: Usuários podem avaliar livros com título, comentário, nota (de 1 a 5), e escolher se a avaliação será pública ou privada. As avaliações podem receber likes.
- **Metas de Leitura**: Defina metas de leitura, como número de livros ou páginas a serem lidas, e ganhe pontos conforme o progresso.
- **Lembretes de Leitura**: Permite que os usuários definam lembretes personalizados para ler seus livros em horários específicos.
- **Recomendações de Livros por IA**: O sistema usa a API da OpenAI GPT para recomendar livros semelhantes aos que o usuário está visualizando ou baseado nas suas leituras anteriores.
- **Listagem de Livros**: Tela de listagem dos livros do usuário com informações sobre o progresso de leitura, livros favoritos e gêneros mais lidos.
- **Notificações**: Utiliza o Firebase Cloud Messaging (FCM) para enviar lembretes de leitura.

## APIs Utilizadas

- **Google Books API**: Para obter informações detalhadas sobre os livros cadastrados, como título, autor, ISBN, etc.  
[Google Books API](https://developers.google.com/books/docs/v1/using?hl=pt-br)
  
- **OpenAI GPT (ChatGPT API)**: Utilizada para recomendações de livros com base no histórico de leitura e preferências do usuário.  
[OpenAI GPT API](https://platform.openai.com/docs/overview)
  
- **Firebase Cloud Messaging (FCM)**: Para enviar notificações push e lembretes de leitura para os usuários.  
[Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging?hl=pt-br)

## Tecnologias Utilizadas

- **Backend**: Laravel (PHP), JWT para autenticação, APIs externas para informações de livros e recomendações.
- **Frontend**: React (para construir interfaces dinâmicas e interativas).
- **Banco de Dados**: MySQL/PostgreSQL para armazenar informações dos usuários, livros e leituras.
- **Notificações**: Firebase Cloud Messaging para enviar notificações aos usuários.

## Como Usar

1. Clone este repositório:
   ```bash
   git clone https://github.com/usuario/repo.git
