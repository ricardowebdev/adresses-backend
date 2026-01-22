## 🚀 Adresses Backend
Projeto backend que tem as seguintes finalidades

1 - Exemplo prático e mais simplificao de mais ou menos construiria uma arquitetura de uma api rest com laravel

2 - Fazer a api para servir a aplicação em frontend armazenando e disponilibilizando informações dos endereços registrados, junto a isso há todo um monitoramento de logs que foi realizado para sua visualização e manutenção e também uma mensageria de notificações importantes via discord. 

A aplicação é construída em Laravel, executada em ambiente Dockerizado, com Nginx como servidor web e SSL/TLS para comunicação segura.

## 🧰 Tecnologias Utilizadas
- PHP8+ (Laravel 11+)
- Nginx
- Docker / Docker Compose
- MySQL
- MongoDB
- SSL / TLS
- REST API

## 🧱 Visão Geral da Arquitetura
Cliente (Frontend / API Client)
  ↓ HTTPS (443)
Nginx
  ↓ FastCGI
PHP-FPM (Laravel)
  ↓
Banco de Dados / Serviços 

- O Nginx recebe as requisições HTTP/HTTPS
- As requisições PHP são encaminhadas para o container PHP via FastCGI
- O Laravel processa regras de negócio, permissões e integrações
- Toda comunicação externa ocorre via HTTPS

## 🐳 Docker & Ambiente
O projeto é totalmente dockerizado, permitindo execução consistente em:
- Produção
- Homologação
- Desenvolvimento local

## 📦 Dockerfile
O Dockerfile define o container responsável por executar a aplicação Laravel.

Responsabilidades principais:
- Preparar o ambiente PHP
- Instalar dependências do Laravel
- Instalar as dependencias de comunicações com os bancos
- Expor a aplicação para o Nginx

## 📄 docker-compose.yml
O docker-compose.yml orquestra os containers do ambiente, normalmente incluindo:
- nginx → Servidor web
- php → PHP-FPM (Laravel)
- database → MySQL 
- mongo → MongoDB
- Cada serviço se comunica internamente pela rede Docker.

## 🌐 Nginx
nginx.conf (Configuração Global)

Funções:
- Define usuário e workers
- Configura logs de acesso e erro
- Ativa compressão Gzip
- Inclui automaticamente os virtual hosts

Destaques:
- worker_processes auto
- gzip on
- include /etc/nginx/conf.d/*.conf


## 000-default.conf (HTTP – Porta 80)
Utilizado principalmente para ambientes locais ou internos.

Configurações:
- Porta: 80
- Root: /usr/share/nginx/html/public
- Entrada padrão: index.php

Fluxo:
- Arquivos estáticos → Nginx
- Arquivos PHP → PHP-FPM (php:9000)
- Nginx → FastCGI → PHP (Laravel)

## default-ssl.conf (HTTPS – Porta 443)
Responsável pelo tráfego seguro em produção.

Configurações principais:
- Porta: 443
- SSL ativo (TLS 1.2 / 1.3)
- Domínio: (dominio configurado)
- Certificados carregados de /etc/nginx/ssl

Fluxo HTTPS:
- Validação SSL
- Encaminhamento PHP via FastCGI
- Retorno seguro ao cliente

## 🔐 Certificados SSL
Arquivos utilizados:
- full_chain.crt
- server.key

## 📂 Caminho no container:
/etc/nginx/ssl/
O Nginx valida o certificado antes de encaminhar qualquer requisição para a aplicação.


## 🚀 Instalação do Ambiente (Produção)
1 - Clonar o projeto no servidor

2 - Revisar os server_name dentro das configuraçõess do nginx para a pasta "Docker"

3 - Colar certificados validos com os mesmos nomes dentro da pasta "certs"

4 - Alterar qualquer configuração necessaria no arquivo docker-compose.yml

5 - Build das imagens - docker compose build

6 - Subir os containers - docker compose up -d

## 🧪 Testes Rápidos
Testar conectividade HTTPS
curl -I https://hostdoprojeto

Verifique:
- Status 200
- Certificado válido
- Ausência de erros 502 ou 504

### Como é implementado o Deploy
- Deixei um github actions pronto dentro do projeto, caso for implementar o deploy automatico é apenas criar os secrets dentro do github e realizar um commit na branch "main" dentro de 40s em media o projeto estará atualizado

## 🛡️ Segurança Aplicada
✔ Comunicação via HTTPS
✔ TLS 1.2 e TLS 1.3
✔ Execução de PHP isolada no container
✔ Bloqueio de acesso a arquivos .ht*
✔ Logs separados (access / error)


## 📁 Organização do Projeto

O projeto está estruturado de forma a garantir separação de responsabilidades, facilidade de manutenção e escalabilidade, seguindo boas práticas de arquitetura para APIs REST.

Rotas
- Todas as rotas da aplicação estão centralizadas no arquivo api.php.
- As rotas definem os endpoints disponíveis e o fluxo de acesso da API.

Middlewares
- Responsáveis por interceptar as requisições antes de chegarem aos controllers.
- Realizam validações de autenticação e autorização de acesso.

Controllers
- Atuam como ponto de entrada das requisições HTTP.
- Validam o fluxo inicial dos dados por meio de Requests.
- Encaminham os dados para processamento na camada de Services.
- Capturam o retorno das operações e constroem as respostas conforme os princípios do protocolo REST.

Services
- Contêm a lógica de negócio da aplicação.
- Processam as informações recebidas dos controllers.
- Executam consultas simples diretamente via Models.
- Delegam consultas mais complexas para a camada de Repositories.
- São responsáveis por acionar a camada de logs em caso de erros e mensagerias.

Repositories
- Encapsulam consultas mais complexas ao banco de dados.
- Isolam a lógica de acesso aos dados da camada de negócio.
- Facilitam manutenção, testes e evolução do sistema.

Models
- Representam a ligação entre a aplicação e os bancos de dados.
- Os dados mais volumosos do sistema são armazenados em um banco NoSQL (MongoDB).
- Para evitar consultas simultâneas entre bancos diferentes, os dados principais permanecem referenciados nos models tradicionais, permitindo consultas mais específicas e eficientes sem a necessidade de acessar ambos os bancos ao mesmo tempo.

## Organização das principais pastas
```text
adresses-backend/
├── app/
│   ├── Console/                 # Comandos personalizados do Laravel
│   ├── Exceptions/              # Tratamento de exceções da aplicação
│   ├── Http/
│   │   ├── Controllers/         # Controladores da API (camada de permissão)
│   │   ├── Middleware/          # Autenticação, linguagem e pré-processamento de rotas
│   │   ├── Requests/            # Validações de requisições (campos e tipos)
│   │   └── Services/
│   │       └── Jobs/            # Processos assíncronos (background)
│   ├── Mail/                    # Templates de e-mails do sistema
│   ├── Models/                  # Modelos de dados (Eloquent)
│   ├── Repositories/            # Camada de acesso a dados e queries complexas
│   ├── Services/                # Regra de negócio e processamento de respostas
│   ├── Contracts/               # Interfaces dos repositórios e serviços
│
├── certs/
│   ├── ca_bundle.crt
│   ├── full_chain.crt
│   ├── server.crt
│   └── server.key
│
├── database/
│   ├── migrations/              # Criação e alteração de tabelas (MySQL)
│   └── seeders/                 # Dados iniciais do banco
│
├── Docker/
│   ├── 000-default.conf         # Configuração padrão do nginx servindo porta 80
│   ├── default-ssl.conf         # Configuração para HTTPS do nginx servindo na porta 443
│   ├── Dockerfile               # Build do container
│   └── init.sql                 # Script de criação do banco
│
├── public/
│   └── firmware/                # Firmwares para download dos dispositivos
│
├── routers/
│   ├── api.php                  # Rotas da API
│   └── web.php                  # Rotas web (redirecionamento para API)
│
├── testes/
│   └── Feature/                 # Testes de funcionalidades da API
│
├── .env.example                 # Exemplo de variáveis de ambiente
├── .gitignore                   # Arquivos ignorados pelo Git
├── artisan                      # CLI do Laravel
├── composer.json                # Dependências PHP
└── composer.lock                # Lock das versões das dependências
```

## 👤 Autor / Maintainer
Ricardo dos Santos Souza
