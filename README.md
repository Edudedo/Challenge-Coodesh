Dictionary API - Challenge by Coodesh

Descrição do Projeto:

A Dictionary API é um projeto backend que serve pra listar palavras em inglês. Com ela, dá pra buscar palavras, favoritar, ver detalhes e gerenciar tudo de um jeito fácil. Foi um desafio técnico que fiz pra Coodesh!


Tecnologias Utilizadas:


Linguagem: PHP
Framework: Laravel 11.x
Banco de Dados: MySQL (via XAMPP)
Cache: Redis
Gerenciador de Dependências: Composer
Ferramentas Adicionais:
Laravel Sanctum (Autenticação)
Postman (Testes de API)
Docker (para Redis pois eu uso Windows)


Funcionalidades Implementadas:

Autenticação de Usuários:

Cadastro de usuários com validação.
Login com geração de tokens JWT utilizando Laravel Sanctum.

Gerenciamento de Palavras:
Listagem de palavras.
Visualização dos detalhes de uma palavra específica.
Favoritar e desfavoritar palavras.

Histórico e Favoritos:
Listagem do histórico de palavras visualizadas.
Listagem de palavras favoritas.

Cache:
Utilização de Redis para cachear respostas e otimizar o desempenho.
Cabeçalhos x-cache (HIT/MISS) e x-response-time adicionados às respostas para monitorar o uso de cache.

Como Instalar e Usar o Projeto:
Pré-requisitos:
PHP (>= 8.1)
Laravel 11.x
Composer
MySQL (via XAMPP ou outro)
Redis

Para usar o projeto basta clonar o repositório do GitHub com:
git clone "https://github.com/Edudedo/Challenge-Coodesh.git"

Instalar as dependencias com:
composer install

configurar o .env:
APP_NAME=DictionaryAPI
APP_ENV=local
APP_KEY=base64:...
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dictionary
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379

Executar as migrações:
php artisan migrate --seed

Iniciar o Redis com o Docker:
docker run --name redis -d -p 6379:6379 redis

Inicia o servidor local do laravel com:
php artisan serve

E por fim testar a API com o Postman com :
http://127.0.0.1:8000/api

Endpoints da API:
Autenticação:
POST /auth/signup: Registro de usuários.
POST /auth/signin: Login e geração de token.

Palavras:
GET /entries/en: Listagem de palavras com suporte a busca e paginação.
GET /entries/en/{word}: Detalhes de uma palavra específica.
POST /entries/en/{word}/favorite: Favoritar uma palavra.
DELETE /entries/en/{word}/unfavorite: Remover uma palavra dos favoritos.

Usuário:
GET /user/me: Perfil do usuário logado.
GET /user/me/history: Histórico de palavras visualizadas.
GET /user/me/favorites: Palavras favoritas.

No Postman fazer a Authorization com o Bearer Token que pegar do login!
