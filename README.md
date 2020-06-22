# Desafio Encurtador de URL

<p>
Um encurtador de URL é um serviço que recebe uma URL qualquer e retorna uma outra, geralmente menor que a original. Ex: bit.ly, TinyURL. 
</p>

## Proposta

Desenvolver uma API RESTful um encurtador de url com as seguintes tecnologias PHP + LUMEN.

+ Retornar uma url cadastrada de acordo com o id fornecido.
+ Cadastrar um novo usuário no sistema.
+ Cadastrar uma nova url no sistema.
+ Apagar uma URL do sistema de acordo com o id fornecido. 
+ Apagar o usuário informado de acordo com o id fornecido. 
+ Retorna estatísticas globais do sistema.
+ Docker file
+ Criar um repositório no GitHub.

## Dependências

- Docker

## Instruções para rodar

Você pode optar rodar de duas formas

Antes de tudo, entre na pasta lumen e renomeie o arquivo `.env.example` para `.env` e também o `phpunit.example.xml` para `phpunit.xml` afim de garantir que as variaveis de ambiente fiquem certas para os testes.

### 1) Execute o arquivo `run.sh` da pasta raiz, podendo ser via terminal com por exemplo:

`sh ./run.sh`

Este comando ira executar uma série de passos que você poderá acompanhar via terminal, referente a:
1) Build
2) Instalação das dependências do framework lumen
3) Rodar migrations para a criação das tabelas
4) O ambiente pode ser acessado em http://localhost

### 2) Execute os seguintes passos separadamente no seu terminal dentro da pasta do projeto:

`docker-compose up --build -d`

`docker run --rm --interactive --tty -v $PWD/lumen:/app composer install`

`docker exec -it php php /var/www/html/artisan migrate`

O ambiente pode ser acessado em http://localhost

### Insomnia collection

A documentação dos endpoints pode ser utilizada via Insomnia ou Postman com o arquivo `insomnia_endpoints.json`

### Tests

Para rodar os testes, apos os containers estarem de "pé", na pasta `/lumen` execute em seu terminal:  ./vendor/bin/phpunit