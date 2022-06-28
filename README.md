# Projeto Empresarial

<p align="center">
  <a href="#requisitos-para-executar">Requisitos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#como-executar">Como executar</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#autores">Autores</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#tecnologias">Tecnologias</a>
</p>

-   [Regras de negócio](https://difficult-baryonyx-f99.notion.site/Projeto-Empresarial-1ef26572b7b34692bc77b53d7141eda4)

## Requisitos para executar

-   [PHP ^8.0](https://www.php.net/downloads.php) Instalado e configurado
-   [Composer](https://getcomposer.org/download/)
-   Para rodar ambiente de desenvolvimento com Laravel Sail
    -   [WSL2](https://docs.microsoft.com/pt-br/windows/wsl/install) - Se estiver no Windows
    -   [Docker](https://docs.docker.com/get-docker/)
-   Se não for utilizar o Laravel Sail para rodar o projeto
    -   [MySQL 8.0](https://www.mysql.com/downloads/) Instalado e configurado corretamente para sua máquina
    -   [NodeJS](https://nodejs.org/en/download/) - Utilize a versão LTS

## Como executar

1. Clone o repositório

```bash
# Clonando
git clone https://github.com/avillagabriella/beacademy-devstart-ametista.git

# Entrando no diretório
cd beacademy-devstart-ametista
```

2. Copie as variáveis de ambiente de exemplo:

```bash
cp .env.example .env
```

> Caso não for utilizar o Sail, você deve ajustar as variáveis do banco de acordo com as suas configurações do MySQL

3. Instale as dependências

```bash
composer install
```

4. Ligar os containers

```bash
./vendor/bin/sail up -d
```

5. Executar as migrations

    - Com Sail
        ```bash
        ./vendor/bin/sail artisan migrate
        ```
    - Com PHP Local
        ```bash
        php artisan migrate
        ```

6. Compilar os assets para utilizar Bootstrap

    - Com Sail
        ```bash
        ./vendor/bin/sail npm install && npm run dev
        ```
    - Com PHP Local
        ```bash
        npm install && npm run dev
        ```

7. ✅ Pronto!
    - Se estiver utilizando o Sail acesse: http://localhost
    - Senão, é só ligar o servidor embutido do PHP com `php artisan serve`

## Autores

-   [@AndersemReis](https://github.com/andersemreis)
-   [@avillagabriella](https://github.com/avillagabriella)
-   [@gabrielcoder](https://github.com/gabrielcoder)
-   [@minosdavi](https://github.com/Ton-devstart)
-   [@gusgalote](https://www.github.com/gusgalote)
-   [@marcelovins](https://github.com/marcelovins)
-   [@Ton-devstart](https://github.com/minosdavi)

## Tecnologias

-   [PHP](https://www.php.net/)
-   [Composer](https://getcomposer.org/)
-   [MySQL](https://www.mysql.com/)
-   [Laravel](https://laravel.com/)
-   [Docker](https://docker.com/)
-   [NodeJS](https://nodejs.org/)
