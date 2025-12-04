# 📘 Braille3D — Manual de Execução (https://github.com/codeByThiago/braille3d)

O **Braille3D** é um sistema desenvolvido como Trabalho de Conclusão de Curso (TCC) com o objetivo de **gerar modelos 3D em Braille** e auxiliar na acessibilidade digital.  
Ele integra autenticação via Google, envio de e-mails automáticos e gerenciamento de usuários em uma plataforma simples e eficiente.


## ✨ Tecnologias Utilizadas

| Tecnologia          | Finalidade                        | Versão / Observações |
|--------------------|------------------------------------|-----------------------|
| **PHP**            | Linguagem de Back-end              | 8.0+ |
| **Composer**       | Gerenciamento de Dependências      | — |
| **MySQL**          | Banco de Dados Relacional          | — |
| **Google OAuth 2.0** | Autenticação de Usuários         | — |
| **PHPMailer**      | Envio de E-mail (via Gmail)        | — |
| **Servidor PHP**   | Ambiente de Execução Local         | PHP Embutido |

---

## 📦 1. Pré-requisitos

Antes de rodar o projeto, instale os softwares abaixo:

### **PHP 8+**
👉 Download: https://www.php.net/downloads  
Verifique a instalação:

```bash
php -v
```

### **Composer**
👉 Download: https://getcomposer.org/download/ 
Verifique a instalação:

```bash
composer -v
```

*Depois, já instale as dependências com Composer:*

```bash
composer install
composer require phpmailer/phpmailer
composer require google/apiclient
composer require vlucas/phpdotenv
```

### **MySql**

👉 Download: https://dev.mysql.com/downloads/installer/

Depois, crie o banco existente na pasta *sql/schema.sql*

## 2. Configuração do Arquivo .env

Crie um arquivo chamado .env na raiz do projeto com a seguinte estrutura.

# --- Banco de Dados (MySQL) ---
DB_HOST="localhost:3307"
DB_USER="root"
DB_PASSWORD="SUA_SENHA_DO_MYSQL"
DB_NAME="braille3d"

# --- PHPMailer (Gmail) ---
GMAIL_USER="seuemail@gmail.com"
GMAIL_PASS="SUA_SENHA_DE_APLICATIVO" // Caso não tenha, certifique-se de criar uma na sua conta google (É extremamente importante que você não coloque a senha da sua conta aqui)

# --- Google OAuth ---
GOOGLE_CLIENT_ID="SUA_CLIENT_ID"
GOOGLE_CLIENT_SECRET="SUA_CLIENT_SECRET"
GOOGLE_REDIRECT_URI="http://localhost:8000/user/google-callback"


## 3. Configuração do Login Google OAuth 2.0

Acesse o Google Cloud Console:
https://console.cloud.google.com/

Crie um novo projeto.

Vá para APIs & Services > OAuth consent screen e configure o aplicativo.

Acesse Credentials > Create Credentials > OAuth Client ID.

Escolha Web Application.

Em Authorized redirect URI, adicione:

*http://localhost:8000/user/google-callback*

Copie:

**Client ID**
**Client Secret**

e adicione ao .env.

## 4. Configuração PHPMailer (via Gmail)

O Gmail exige uma Senha de Aplicativo, não a senha normal.

Acesse sua conta do Google → Segurança.

Ative a Verificação em 2 etapas.

Após ativar, aparecerá Senhas de Aplicativos.

*Crie uma senha:*

O Google exibirá uma senha como:

abcd efgh ijkl mnop // EXEMPLO

Use essa senha no .env:

```.env
GMAIL_PASS="abcd efgh ijkl mnop"
```

## 5. Rodando o Projeto

Execute o servidor embutido do PHP:

```bash
cd public
php -S localhost:8000
```

Acesse no navegador:

http://localhost:8000
