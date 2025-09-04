# CRUD Completo em PHP com PostgreSQL, Tailwind e MVC

[![PHP](https://img.shields.io/badge/PHP-7.x%2F8.x-blue?logo=php\&logoColor=white)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-green?logo=postgresql\&logoColor=white)](https://www.postgresql.org/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-3.x-teal?logo=tailwindcss\&logoColor=white)](https://tailwindcss.com/)
[![VSCode](https://img.shields.io/badge/VSCode-1.x-blueviolet?logo=visual-studio-code\&logoColor=white)](https://code.visualstudio.com/)
[![DBeaver](https://img.shields.io/badge/DBeaver-25.2.0-orange?logo=dbeaver\&logoColor=white)](https://dbeaver.io/)
[![License](https://img.shields.io/badge/License-MIT-lightgrey)](LICENSE)

Projeto de **CRUD (Create, Read, Update, Delete)** completo em PHP, seguindo o padrão **MVC**, com banco **PostgreSQL** e interface moderna com **Tailwind CSS**.
Ideal para uso com **VSCode** e **DBeaver**.

---

## Tecnologias

* PHP 7.x ou 8.x
* PostgreSQL
* Tailwind CSS (via CDN moderna)
* VSCode como editor de código
* DBeaver para gerenciamento do banco
* PDO para acesso seguro ao banco de dados
* MVC (Model-View-Controller)
* Servidor local (PHP nativo ou XAMPP)

---

## Funcionalidades

* Listar usuários cadastrados
* Adicionar novo usuário
* Editar usuário existente
* Deletar usuário

---

## Estrutura do Projeto

```
crud-completo-php/
│
├── app/
│   ├── controllers/
│   │   └── UsuarioController.php
│   ├── models/
│   │   └── Usuario.php
│   └── views/
│       └── usuario/
│           ├── index.php
│           ├── criar.php
│           └── editar.php
│
├── config/
│   └── Database.php
├── public/
│   ├── index.php
│   └── assets/
└── README.md
```

---

## Instalação e Configuração

1. Clone o repositório no VSCode:

```bash
git clone https://github.com/seu-usuario/crud-completo-php.git
```

2. Abra o projeto no VSCode.

3. Crie o banco de dados no **PostgreSQL** usando **DBeaver**:

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

4. Configure a conexão em `config/Database.php`:

```php
private $host = "localhost";
private $db_name = "crud_completo";
private $username = "postgres"; // seu usuário
private $password = "sua_senha"; // sua senha
```

5. Abra o terminal do VSCode e rode o servidor PHP:

```bash
php -S localhost:8080 -t public
```

6. Abra no navegador:

```
http://localhost:8080/
```

---

## Como usar

* **Listar usuários:** Página inicial
* **Criar usuário:** Clique em “Adicionar Usuário”
* **Editar usuário:** Clique em “Editar” ao lado do usuário
* **Deletar usuário:** Clique em “Excluir” e confirme

---

## Boas práticas implementadas

* Estrutura **MVC** para separar lógica, dados e interface
* **PDO + prepared statements** (evita SQL Injection)
* Uso de `__DIR__` para incluir arquivos de forma segura
* Interface moderna e responsiva com **Tailwind CSS 3.x via CDN**
* Views totalmente estilizadas e consistentes
* Rotas simples usando query string (`?acao=index`, `?acao=criar`, etc.)

---

## Contribuição

Contribuições são bem-vindas! Crie **issues** ou **pull requests**.
