# Audax WebCrawler
> Facilita a pesquisa e manipulação das paginas.

Faz a leitura de um arquivo no formato csv de dentro da pasta data,
faz a pesquisa utilizando o Handle selecionado, e salva os resultados dentro da pasta results.

## Pré-requisitos

Para utilizar esse projeto é necessario ter as seguintes aplicações instaladas:

| Aplicação | Versão |
|-----------|--------|
| Git       | Ultima |
| PHP       | 7.2.*  |
| Composer  | Ultima |

## Instalação

Clone esse repositório:

```sh
git clone https://github.com/rafaeldimas/webcrawler.git
```

Acesse a pasta do projeto e instale as dependencias:

```sh
cd webcrawler/ && composer install
```

Quando for utilizar suba o servidor embutido do php:

```sh
php -S localhost:8080
```

## Exemplo de uso

Para utilizar esse projeto, é preciso configurar qual arquivo vai ser consumido e qual handle vai ser utilizado.

Abrindo o arquivo index.php, você vera as seguintes linhas:

'''php
<?php

use WebCrawler\App;

ignore_user_abort(true);
set_time_limit(0);

require_once __DIR__. '/bootstrap.php';

define('FILE_NAME', 'REPLACE_WITH_FILE_NAME');
define('TYPE_CRAWLER', 'REPLACE_WITH_HANDLER');

App::init();
'''

É preciso subistituir os valores das constantes pelos seus respectivos valores.

*FILE_NAME:* Essa constante vai determinar qual arquivo vai ser lido para efetuar as buscas, não é preciso colocar a estensão do arquivo, o script vai buscar um arquivo com o nome informado na pasta data e com a extensão csv, essa constante também determina qual o nome dos arquivos de resultado, todos os resultados vão estar presentes em dois arquivos que estaram presentes dentro da pasta results com os seguintes nomes: FILE_NAME-success.csv e FILE_NAME-unsuccess.csv

*TYPE_CRAWLER:* Essa constante determina qual Handler vai ser utilizado, os Handlers são carregados utilizando os arquivos presentes dentro da pasta config/handler, essa constante precisa ter o valor igual ao nome de algum desses arquivos sem a extensão.
