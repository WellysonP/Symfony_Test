# Guia de Início Rápido

## Requisitos

- Docker
- Symfony CLI

## Configuração do Ambiente

### 1. Instalar o Docker

Certifique-se de ter o Docker instalado em sua máquina. Você pode baixá-lo e instalá-lo a partir do [site oficial do Docker](https://www.docker.com/get-started).

### 2. Pull da Imagem do PostgreSQL

Execute o seguinte comando para baixar a imagem do PostgreSQL do Docker Hub:

```bash
docker pull postgres
```

### 3. Iniciar uma Instância do PostgreSQL

Execute o seguinte comando para iniciar uma instância do PostgreSQL:

```bash
docker run -p 5432:5432 -e POSTGRES_PASSWORD=1234 postgres
```

Este comando inicia uma instância do PostgreSQL com a senha "1234" e mapeia a porta 5432 do contêiner para a porta 5432 do host.

### 4. Iniciar o Servidor Symfony

Após iniciar a instância do PostgreSQL, você pode iniciar o servidor Symfony com o seguinte comando:

```bash
symfony server:start
```

Isso iniciará o servidor Symfony e disponibilizará sua aplicação para acesso local.

## Acesso à Aplicação

Uma vez que o servidor Symfony esteja em execução, você pode acessar sua aplicação em http://localhost:8000 no seu navegador web.
