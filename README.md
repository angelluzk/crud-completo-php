# CRUD Completo em PHP com PostgreSQL, Tailwind e MVC

[![PHP](https://img.shields.io/badge/PHP-7.x%2F8.x-blue?logo=php\&logoColor=white)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-green?logo=postgresql\&logoColor=white)](https://www.postgresql.org/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-teal?logo=tailwindcss\&logoColor=white)](https://tailwindcss.com/)
[![VSCode](https://img.shields.io/badge/VSCode-1.x-blueviolet?logo=visual-studio-code\&logoColor=white)](https://code.visualstudio.com/)
[![DBeaver](https://img.shields.io/badge/DBeaver-25.2.0-orange?logo=dbeaver\&logoColor=white)](https://dbeaver.io/)
[![License](https://img.shields.io/badge/License-MIT-lightgrey)](LICENSE)

Projeto de **CRUD (Create, Read, Update, Delete)** completo em PHP, seguindo o padrão **MVC**, com banco **PostgreSQL**, interface moderna com **Tailwind CSS** e proteção **CSRF**.
Ideal para uso com **VSCode** e **DBeaver**.

---

## Tecnologias

* PHP 7.x ou 8.x
* PostgreSQL
* Tailwind CSS (via CDN moderna)
* PDO para acesso seguro ao banco de dados
* MVC (Model-View-Controller)
* FastRoute (roteamento leve e performático)
* Dotenv (configuração via `.env`)
* Logger personalizado
* Proteção CSRF (Cross-Site Request Forgery)

---

## Funcionalidades

* Listar usuários cadastrados
* Adicionar novo usuário
* Editar usuário existente
* Deletar usuário
* Proteção CSRF em todos os formulários

---

## Estrutura do Projeto

```
crud-completo-php/
│
├─ app/
│  ├─ Config/
│  │   └─ Database.php
│  ├─ Controllers/
│  │   └─ UsuarioController.php
│  ├─ Core/
│  │   ├─ Router.php
│  │   ├─ View.php
│  │   ├─ Validator.php
│  │   ├─ Logger.php
│  │   └─ Csrf.php
│  ├─ Models/
│  │   └─ Usuario.php
│  └─ Repositories/
│      └─ UsuarioRepository.php
│
├─ public/
│  └─ index.php
│
├─ views/
│  ├─ usuario/
│  │   ├─ criar.php
│  │   ├─ editar.php
│  │   └─ index.php
│  └─ errors/
│      ├─ 404.php
│      ├─ 405.php
│      └─ 500.php
│
├─ .env
├─ .env.example
├─ .gitignore
├─ composer.lock
├─ composer.json
├─ vendor/
└─ README.md
```

---

## Instalação e Configuração

1. Clone o repositório:

```bash
git clone https://github.com/seu-usuario/crud-completo-php.git
```

2. Instale as dependências:

```bash
composer install
```

3. Crie o banco de dados no **PostgreSQL**:

```sql
CREATE DATABASE crud_completo;

CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Configure o arquivo `.env` na raiz do projeto:

```env
APP_ENV=development
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=crud_completo
DB_USERNAME=postgres
DB_PASSWORD=sua_senha
```

5. Rode o servidor embutido do PHP:

```bash
php -S localhost:8080 -t public
```

6. Abra no navegador:

```
http://localhost:8080/
```

---

## CSRF (Cross-Site Request Forgery)

O projeto implementa proteção **CSRF** para todos os formulários.

### Como funciona:

* Um token é gerado e armazenado na sessão (`Csrf::generateToken()`).
* Esse token é incluído em todos os formulários como campo oculto (`Csrf::inputField()`).
* O Controller valida o token em cada requisição POST (`Csrf::validateToken()`).

### Exemplo no formulário:

```php
<form action="/usuarios" method="POST">
    <?= \App\Core\Csrf::inputField(); ?>
    <!-- campos do formulário -->
</form>
```

---

## Boas práticas implementadas

* Estrutura **MVC** para separar lógica, dados e interface
* **PDO + prepared statements** para evitar SQL Injection
* Configuração centralizada via **.env** (com `vlucas/phpdotenv`)
* Roteamento limpo com **FastRoute**
* **CSRF token** em todos os formulários (segurança contra ataques)
* Views com **Tailwind CSS 3.x**
* Logger de erros personalizado

---

## Contribuição

Contribuições são bem-vindas!
Abra uma **issue** ou envie um **pull request**.
