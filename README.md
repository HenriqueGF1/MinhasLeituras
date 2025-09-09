# 📚 Gerenciamento de Leituras

[![Laravel](https://img.shields.io/badge/Laravel-8.x-red)](https://laravel.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-blue)](https://www.postgresql.org/)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-tested-blue)](https://phpunit.de/)
[![Swagger](https://img.shields.io/badge/Swagger-API-blue)](https://swagger.io/)
[![JWT](https://img.shields.io/badge/JWT-auth-orange)](https://jwt.io/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Este projeto é uma aplicação de **gerenciamento de leituras** que permite aos usuários cadastrar, organizar e acompanhar seu progresso em livros, HQs e outros materiais.  
Com ele, é possível definir metas, registrar avaliações, acompanhar estatísticas, receber lembretes de leitura e muito mais.

---

## 🚀 Tecnologias Utilizadas

-   **Backend**: [Laravel](https://laravel.com/) (PHP)
-   **Autenticação**: JWT (JSON Web Tokens)
-   **Testes**: PHPUnit
-   **Documentação de API**: Swagger
-   **Banco de Dados**: [PostgreSQL](https://www.postgresql.org/)

---

## 📡 APIs Integradas

-   **[Google Books API](https://developers.google.com/books/docs/v1/using?hl=pt-br)**  
    Para buscar informações completas dos livros, como título, autor, ISBN, capa e descrição.

---

## 📌 Funcionalidades

-   **Autenticação de Usuário**

    -   Cadastro com nome, e-mail, senha e data de nascimento
    -   Login com geração de token JWT
    -   Logout

-   **Gerenciamento de Livros**

    -   Cadastro de livros, HQs, etc.
    -   Pesquisa por ISBN
    -   Listagem, pesquisa e exclusão de livros

-   **Progresso de Leitura**

    -   Registro diário do número de páginas lidas
    -   Acompanhamento da evolução de leitura

-   **Avaliações de Livros**
    -   Criação de avaliações
    -   Listagem e exclusão de avaliações

---

## 🏁 Passo a Passo para Baixar e Iniciar o Projeto

PASSO A PASSO PARA BAIXAR E INICIAR O PROJETO

1. Clone o repositório:
   </br> `git clone https://github.com/HenriqueGF1/MinhasLeituras.git` </br>
   `cd MinhasLeituras` </br>
2. Instale as dependências do backend (Laravel):
   </br> `composer install` </br>

3. Copie o arquivo de exemplo de configuração do Laravel e configure as chaves:
   </br> `cp .env.example .env`
   </br> Abra o arquivo .env e configure: </br>
   `JWT_SECRET=sua_chave_jwt_aqui` </br>
   `GOOGLE_BOOKS_API_KEY=sua_chave_google_books_aqui` </br>
   `` </br>

4. Gere a chave do aplicativo Laravel (APP_KEY):
   </br> `php artisan key:generate` </br>

<!-- 5. Execute as migrations do banco de dados:
   </br> `php artisan migrate` </br> -->

5. Gere o banco de dados , pelo arquivo
   </br> `sql.sql` </br>

6. Inicie o servidor Laravel:
   </br> `composer run dev` </br>

7. Para ver a Documentação da API:
   </br> `endereco_da_sua_aplicacao/api/rotas` </br>

8. Caso queira visualizar as rotas, basta importar o arquivo `MinhasLeituras.postman_collection.json` no Postman:

![Imagem Documentacao Api](/printsREADME/documentacao-api.png)

9. Teste a aplicação:
   </br> `composer run testar` </br>

</br></br>
IMPORTANTE: Não compartilhe suas chaves de API ou JWT em repositórios públicos.
