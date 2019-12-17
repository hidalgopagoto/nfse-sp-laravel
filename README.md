# nfse-sp-laravel
Gerador de NFs-e para a cidade de São Paulo utilizando Laravel 5.8

É recomendável fazer a instalação do Laradock (https://laradock.io/). Para o primeiro release, foram utilizados os contâineres nginx, mysql e phpmyadmin.

Acessar, dentro da pasta do laradock, a pasta nginx/sites e executar:

cp laravel.conf.example nfse-sp-laravel.local (evitar utilizar .dev)

Editar o arquivo recém criado e corrigir as linhas:

    server_name laravel.test;
    root /var/www/laravel/public;

para:

    server_name nfse-sp-laravel.local;
    root /var/www/nfse-sp-local/public;

Após essa etapa, adicionar ao hosts da máquina (geralmente localizado em /etc/hosts):

    127.0.1.1       nfse-sp-laravel.local

Após essa etapa, entrar novamente na pasta do laradock e executar o comando:

    docker-compose up nginx mysql phpmyadmin

O projeto já deve estar rodando na url http://nfse-sp-laravel.local

Por padrão, o laradock criará um usuário com o login *default* e a senha *secret* para o mysql. Para este projeto, foi utilizada a versão 5.7 do Mysql. Portanto, dentro da pasta do laradock, faça uma alteração no arquivo .env, na seguinte linha:

    MYSQL_VERSION=latest

Para

    MYSQL_VERSION=5.7

Como foi alterada a versão do Mysql, é necessário dar build do container. Rodar os seguintes comandos na pasta do laradock:

    docker-compose down
    docker-compose build --no-cache mysql

Após concluído, rodar o comando

    docker-compose up nginx mysql phpmyadmin

Após finalizado, podemos entrar no container que possui o mysql através do seguinte comando:

    docker-compose exec mysql bash

Dentro da máquina, podemos fazer login no mysql com root, utilizando

    mysql -u root -p
    Senha: root

E, dentro do mysql, autorizar o usuário default a realizar operações

    GRANT ALL PRIVILEGES ON *.* TO 'default'%'%' IDENTIFIED BY 'secret';
    FLUSH PRIVILEGES;

Para acessar o container que possui o PHP, rodar o comando:

    docker-compose exec workspace bash

Dentro do container, acessar a pasta nfse-sp-laravel e, dentro dela, rodar o comando:

    composer install

Para instalar as dependências do Laravel.

Acessar o container do mysql novamente com o comando:

    docker-compose exec mysql bash

E, dentro dela, fazer login com o user **default**

    mysql -u default -p
    Senha: secret

E criar a base de dados que será utilizada

    CREATE DATABASE nfse_php_laravel

Após executadas estas tarefas, copiar o arquivo .env.example, da raiz do projeto, para um arquivo chamado .env, também na raiz, e configurar os acessos de banco:

    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=nfse_sp_laravel
    DB_USERNAME=default
    DB_PASSWORD=secret

A informação **mysql** no campo HOST significa que o container irá buscar outro container com o nome **mysql** para fazer a conexão

Após configurado, entrar na máquina do PHP novamente com o comando:

    docker exec workspace bash

E, dentro da pasta do projeto, rodar o comando

    php artisan migrate

Para criar as tabelas necessárias.

Para criar um usuário de teste, dentro do container do php, rodar o comando:

    php artisan db:seed --class=LocalUserSeeder

Que irá imprimir o token gerado. Esse token deverá ser enviado como Bearer para as requisições via API através do header Authorization
