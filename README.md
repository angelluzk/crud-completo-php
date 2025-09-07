# CRUD Completo em PHP com Arquitetura Profissional

[![PHP](https://img.shields.io/badge/PHP-7.x%2F8.x-blue?logo=php\&logoColor=white)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-green?logo=postgresql\&logoColor=white)](https://www.postgresql.org/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-teal?logo=tailwindcss\&logoColor=white)](https://tailwindcss.com/)
[![VSCode](https://img.shields.io/badge/VSCode-1.x-blueviolet?logo=visual-studio-code\&logoColor=white)](https://code.visualstudio.com/)
[![DBeaver](https://img.shields.io/badge/DBeaver-25.2.0-orange?logo=dbeaver\&logoColor=white)](https://dbeaver.io/)
[![License](https://img.shields.io/badge/License-MIT-lightgrey)](LICENSE)

Um projeto de **CRUD (Create, Read, Update, Delete)** de usuários, desenvolvido em PHP puro com uma arquitetura moderna e escalável. Utiliza o padrão **MVC**, Injeção de Dependência, Repositórios e um roteador performático para criar uma base sólida para aplicações web robustas e de fácil manutenção.

O projeto foi construído do zero com foco em boas práticas, segurança e organização, resultando em um código limpo, coeso e desacoplado.

-----

## ✨ Principais Características

  * **Arquitetura MVC Real:** Separação clara de responsabilidades entre Modelos (Entidades), Visões (Templates PHP) e Controladores.
  * **Injeção de Dependência:** Um contêiner de DI simples gerencia a criação de objetos e suas dependências, tornando o sistema flexível e testável.
  * **Padrão Repositório:** A lógica de acesso ao banco de dados é abstraída, permitindo que a aplicação trabalhe com objetos e não diretamente com queries SQL.
  * **Roteamento Limpo:** URLs amigáveis e performáticas gerenciadas pela biblioteca `FastRoute`, com cache de rotas para produção.
  * **Segurança:**
      * **Proteção CSRF** em todos os formulários com tokens de uso único.
      * Uso de **PDO com Prepared Statements** para prevenir SQL Injection.
      * **Escaping de saídas** HTML para prevenir ataques XSS.
  * **Configuração Centralizada:** Uso de variáveis de ambiente (`.env`) para gerenciar configurações sensíveis (banco de dados, ambiente da aplicação).
  * **Sistema de Views com Layouts:** Evita repetição de código HTML com um sistema de layout principal ("moldura") e views de conteúdo ("fotos").
  * **Estrutura de Projeto Profissional:** Organização de pastas e arquivos que separa o código-fonte (`app`), os arquivos públicos (`public`) e os arquivos gerados (`storage`).

-----

## 🛠️ Tecnologias Utilizadas

  * **Back-end:** PHP 8.1+
  * **Banco de Dados:** PostgreSQL 12+
  * **Front-end:** Tailwind CSS (via Play CDN para desenvolvimento)
  * **Dependências (via Composer):**
      * `vlucas/phpdotenv`: Para carregar variáveis de ambiente.
      * `nikic/fast-route`: Para o sistema de roteamento.
  * **Servidor:** Servidor embutido do PHP ou ambiente local como XAMPP/Docker com Apache/Nginx.

-----

## 📂 Estrutura do Projeto

```
crud-completo-php/
│
├── app/
│   ├── Config/
│   │   └── Database.php         # Conexão com o banco (Singleton)
│   ├── Controllers/
│   │   └── UsuarioController.php  # Orquestra as requisições
│   ├── Core/
│   │   ├── Csrf.php             # Gerencia tokens CSRF
│   │   ├── Logger.php           # Grava logs de erro
│   │   ├── Router.php           # Wrapper para o FastRoute
│   │   ├── Validator.php        # Valida os dados de entrada
│   │   └── View.php             # Renderiza as views com layouts
│   ├── Models/
│   │   └── Usuario.php          # Entidade de dados do usuário
│   ├── Repositories/
│   │   └── UsuarioRepository.php  # Lógica de persistência de dados
│   └── helpers.php              # Funções auxiliares globais (url(), redirect())
│
├── public/
│   ├── .htaccess                # Regras de reescrita para o Apache
│   └── index.php                # Ponto de Entrada (Front Controller)
│
├── storage/
│   ├── cache/                   # Cache de rotas (gerado)
│   │   └── .gitkeep
│   └── logs/                    # Logs da aplicação (gerado)
│       └── .gitkeep
│
├── views/
│   ├── erros/                   # Views para páginas de erro (404, 500)
│   ├── layout/
│   │   └── app.php              # Layout principal da aplicação
│   └── usuario/                 # Views específicas do CRUD de usuário
│
├── .env                         # Suas variáveis de ambiente locais (NÃO VERSIONAR)
├── .env.example                 # Arquivo de exemplo para configuração
├── .gitignore                   # Arquivos e pastas a serem ignorados pelo Git
├── composer.json                # Definição do projeto e dependências
├── composer.lock                # Trava as versões exatas das dependências
└── README.md
```

-----

## 🚀 Como Executar o Projeto (Guia Detalhado)

Siga estes passos para configurar e rodar o ambiente de desenvolvimento localmente.

### 1\. Pré-requisitos

  * **PHP 8.1** ou superior
  * **Composer** instalado
  * **PostgreSQL** instalado e rodando

### 2\. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/crud-completo-php.git
cd crud-completo-php
```

### 3\. Instale as Dependências

O Composer irá baixar todas as bibliotecas necessárias.

```bash
composer install
```

### 4\. Crie o Banco de Dados e a Tabela

Conecte-se ao seu PostgreSQL (usando DBeaver, pgAdmin, ou `psql`) e execute os seguintes comandos SQL:

```sql
CREATE DATABASE crud_completo;
```

```sql
-- Conecte-se ao banco crud_completo antes de rodar este comando
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    criado_em TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);
```

### 5\. Configure as Variáveis de Ambiente

1.  Copie o arquivo de exemplo `.env.example` para um novo arquivo chamado `.env`.

    ```bash
    cp .env.example .env
    ```

2.  Abra o arquivo `.env` e preencha com suas configurações locais. **Preste atenção especial à `APP_URL`**.

    ```dotenv
    # Application Environment
    APP_ENV=development
    APP_URL=http://localhost:8080/crud-completo-php/public # Se usar o servidor embutido do PHP
    # APP_URL=http://crud.test # Se usar um Virtual Host (Opção B abaixo)

    # Database Connection
    DB_HOST=localhost
    DB_PORT=5432
    DB_DATABASE=crud_completo
    DB_USERNAME=postgres
    DB_PASSWORD=sua_senha_secreta
    ```

### 6\. Crie as Pastas de Armazenamento

O sistema de log e cache precisa de pastas com permissão de escrita.

```bash
mkdir -p storage/logs storage/cache
```

*(Em ambientes Linux/Mac, talvez seja necessário dar permissão de escrita para o servidor web: `sudo chmod -R 775 storage`)*

### 7\. Execute a Aplicação

Você tem duas opções principais:

#### Opção A (Mais Simples): Usando o Servidor Embutido do PHP

Este comando inicia um servidor web diretamente na pasta `public`, que é a forma correta.

```bash
php -S localhost:8080 -t public
```

Agora, acesse no navegador: **`http://localhost:8080`**

#### Opção B (Mais Profissional): Usando um Ambiente como o XAMPP/WAMP com Virtual Host

Configurar um Virtual Host permite que você acesse seu projeto por uma URL amigável (como `http://crud.test`) e é a forma como ambientes de produção funcionam.

1.  **Edite o arquivo `hosts` do seu sistema** para mapear um domínio local para o seu computador.

      * (Windows: `C:\Windows\System32\drivers\etc\hosts`)
      * (Linux/Mac: `/etc/hosts`)
      * Adicione a linha: `127.0.0.1 crud.test`

2.  **Edite o arquivo de configuração de Virtual Hosts do Apache** (ex: `C:\xampp\apache\conf\extra\httpd-vhosts.conf`). Adicione o seguinte bloco:

    ```apache
    <VirtualHost *:80>
        DocumentRoot "C:/caminho/completo/para/seu/projeto/crud-completo-php/public"
        ServerName crud.test
        <Directory "C:/caminho/completo/para/seu/projeto/crud-completo-php/public">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```

    *(Ajuste o `DocumentRoot` para o caminho real da sua pasta `public`)*

3.  **Reinicie o Apache.**

4.  Ajuste a `APP_URL` no seu `.env` para `http://crud.test`.

5.  Acesse no navegador: **`http://crud.test`**

-----

## 🤝 Contribuição

Contribuições são muito bem-vindas\! Sinta-se à vontade para abrir uma **issue** para relatar um bug ou sugerir uma melhoria, ou enviar um **pull request** com suas alterações.

-----

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](https://www.google.com/search?q=LICENSE) para mais detalhes.