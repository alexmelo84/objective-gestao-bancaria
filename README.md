# Introdução

Esse é um projeto para o desafio técnico de gestão bancária da Objective.

## Stack

Roda em um container Docker com a [imagem](https://hub.docker.com/r/shinsenter/laravel).

Essa imagem instala e executa uma aplicação em Laravel mais recente.

Como banco de dados utiliza um MySQL.

## Utilização

Faça o clone do projeto:

- com SSH:
```
git clone git@github.com:alexmelo84/objective-gestao-bancaria.git
```

- ou com HTTPS:
```
git clone https://github.com/alexmelo84/objective-gestao-bancaria.git
```

Após terminar o download do projeto, execute o Docker:
```
docker compose up
```

Dando tudo certo, devem aparecer as seguintes mensagens no log:
```
NOTICE: fpm is running, pid 5166
NOTICE: ready to handle connections
```

A aplicação rodará na porta *:8000* então toda ass chamadas deverão ser feitas via Postman ou aplicações semelhantes através dessa porta.
