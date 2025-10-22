# 🛠️ Sistema de Gestão de Tarefas

Este projeto é um sistema completo de gerenciamento de tarefas, desenvolvido com Laravel e MySQL. Ele oferece autenticação de usuários e permite o controle eficiente de projetos e tarefas, facilitando a organização, acompanhamento e colaboração dentro de equipes.

## 🚀 Tecnologias Utilizadas

- Laravel (Última versão estável)
- Laravel Breeze (Autenticação)
- Banco de dados MySQL (Base de dados)
- Tailwild (Para o layout)

## 📌 1. Instalação do Projeto
Siga os passos abaixo para instalar e configurar o sistema em sua máquina.


### 🔹 1.1 Clonar o Repositório
```sh
git clone git@github.com:rodrigoaguerra/teste-leme.git
cd teste-leme
```
### 🔹 1.2 Instalar Dependências
```sh
composer install
npm install
```

### 🔹 1.3 Configurar o Banco de Dados
1. **Crie um banco de dados no MySQL**
2. **Copie o arquivo de configuração**
```sh
cp .env.example .env
```
3. **Edite o arquivo** .env e configure a conexão com o banco:
```ini
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=root
DB_PASSWORD=sua_senha
```
### 🔹 1.4 Gerar a Key do Laravel
```sh
php artisan key:generate
```
### 🔹 1.5 Criar o link simbólico para arquivos
```sh
php artisan storage:link
```
### 🔹 1.6 Executar as Migrations e Seeders
```sh
php artisan migrate --seed
```
#### O Seeder cria um usuário automaticamente 1:
 - **Email:** test1@example.com
 - **Senha:** password

#### O Seeder cria um usuário automaticamente 2:
 - **Email:** test2@example.com
 - **Senha:** password

#### O Seeder cria um usuário automaticamente 3:
 - **Email:** test3@example.com
 - **Senha:** password

#### O Seeder cria um usuário automaticamente 4:
 - **Email:** test4@example.com
 - **Senha:** password

#### O Seeder cria um usuário automaticamente 5:
 - **Email:** test5@example.com
 - **Senha:** password

### 🔹 1.7 Compilar o front-end
```sh
npm run build
```

### 🔹 1.8 Iniciar o Servidor
```sh
php artisan serve
```
O sistema estará disponível em: http://localhost:8000


## 📌 2. Funcionalidades
- ✅ Login e Registro de Usuários
- ✅ Gerenciamento de Projetos
- ✅ Gerenciamento de Tarefas
- ✅ Painel básico com Tailwild


## 📌 3. Créditos
Desenvolvido por **Rodrigo Alves Guerra 🖥️🚀**

## 📌 4. Demo
[Sistema em produção](https://leme.rodrigoalvesguerra.com.br)
