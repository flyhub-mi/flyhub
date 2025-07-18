# FlyHub Integração de Marketplaces

Uma plataforma de integração multi-canal de e-commerce construída com Laravel.

> 🇧🇷 **Leia em Português**: [README.pt-BR.md](README.pt-BR.md)
> **📸 Screenshots**: [SCREENS.md](SCREENS.md)

## Funcionalidades

- Arquitetura multi-tenant
- Integração com múltiplas plataformas de e-commerce:
  - MercadoLivre
  - WooCommerce
  - Magento/Magento2
  - Bling
  - TotalExpress
  - Sisplan
  - Vendure
- Sincronização de produtos
- Gerenciamento de pedidos
- Controle de estoque
- Design API-first

## Documentação

- **📸 Screenshots**: [SCREENS.md](SCREENS.md) - Visão geral visual da interface da aplicação
- **🔒 Segurança**: [SECURITY.md](SECURITY.md) - Diretrizes de segurança e melhores práticas
- **🚀 Deploy**: [DEPLOYMENT.md](DEPLOYMENT.md) - Instruções de deploy
- **🇺🇸 English**: [README.md](README.md) - Documentação em inglês

## Início Rápido

Quer começar rapidamente? Aqui está a configuração mínima:

```bash
# 1. Clone e configure
git clone <url-do-repositório>
cd flyhub-app
composer install
yarn install

# 2. Configure o ambiente
cp .env.example .env
# Edite .env com suas credenciais de banco de dados

# 3. Configure o banco de dados e dados de demonstração
php artisan migrate
php artisan db:seed
php artisan passport:install

# 4. Inicie a aplicação
php artisan serve
yarn dev

# 5. Faça login com credenciais de demonstração
# Acesse: http://localhost:8000/login
# Email: admin@demo.com
# Senha: password123
```

## Requisitos

- PHP 8.1+
- MySQL 8.0+
- Node.js 14+
- Composer
- Yarn

## Instalação

### 1. Clone o repositório
```bash
git clone <url-do-repositório>
cd flyhub-app
```

### 2. Instale as dependências PHP
```bash
composer install
```

### 3. Instale as dependências Node.js
```bash
yarn install
```

### 4. Configuração do ambiente
```bash
cp env.example .env
```

Atualize o arquivo `.env` com suas credenciais. **Importante**: Nunca faça commit do arquivo `.env` no controle de versão!

```env
# Obrigatório: Gerar chave da aplicação
APP_KEY=                    # Execute: php artisan key:generate

# Configuração do Banco de Dados
DB_PASSWORD=sua_senha

# Configuração AWS (se usar S3)
AWS_ACCESS_KEY_ID=sua_chave_aws
AWS_SECRET_ACCESS_KEY=sua_chave_secreta_aws

# Integração MercadoLivre (se usar)
MELI_CLIENT_ID=seu_client_id_meli
MELI_CLIENT_SECRET_KEY=sua_chave_secreta_meli

# Outros serviços conforme necessário...
```

**⚠️ Nota de Segurança**: Veja [SECURITY.md](SECURITY.md) para diretrizes detalhadas de configuração de segurança.

### 5. Gere a chave da aplicação
```bash
php artisan key:generate
```

### 6. Configure o banco de dados
```bash
# Crie o banco de dados e usuário (execute como root do MySQL)
mysql -u root -p < database/setup.sql

# Execute as migrações
php artisan migrate

# Popule dados iniciais
php artisan db:seed
```

### 7. Instale o Laravel Passport
```bash
php artisan passport:install
```

### 8. Compile os assets do frontend
```bash
yarn dev
```

## Dados de Demonstração

Após executar os seeders, os seguintes dados de demonstração estarão disponíveis para teste:

### Tenants de Demonstração

A aplicação vem com 3 tenants de demonstração para testar a funcionalidade multi-tenant:

#### 1. Demo Store
- **ID**: `demo-store`
- **Domínio**: `demo-store.localhost`
- **Empresa**: Demo E-commerce Store LTDA
- **Localização**: São Paulo, SP
- **Contato**: contact@demo-store.com

#### 2. Test Shop
- **ID**: `test-shop`
- **Domínio**: `test-shop.localhost`
- **Empresa**: Test Shop Comércio Eletrônico LTDA
- **Localização**: Rio de Janeiro, RJ
- **Contato**: info@test-shop.com

#### 3. Sample Mart
- **ID**: `sample-mart`
- **Domínio**: `sample-mart.localhost`
- **Empresa**: Sample Mart Distribuidora LTDA
- **Localização**: Belo Horizonte, MG
- **Contato**: sales@sample-mart.com

### Usuários de Demonstração

A aplicação inclui 4 usuários de demonstração com diferentes funções:

| Usuário | Email | Função | Senha |
|---------|-------|--------|-------|
| Admin User | admin@demo.com | admin | password123 |
| Manager User | manager@demo.com | manager | password123 |
| Demo User | user@demo.com | user | password123 |
| Support User | support@demo.com | support | password123 |

### Testando com Dados de Demonstração

Você pode usar essas credenciais para testar diferentes aspectos da aplicação:

```bash
# Teste funcionalidade de admin
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@demo.com", "password": "password123"}'

# Teste operações específicas de tenant
php artisan tenants:run --tenants=demo-store queue:work
php artisan tenants:run --tenants=test-shop sync --argument="type=receive" --argument="resource=products"
```

## Uso

### Iniciar Servidor de Desenvolvimento
```bash
# Iniciar servidor de desenvolvimento Laravel
php artisan serve

# Iniciar watcher do frontend (em outro terminal)
yarn watch
```

### Autenticação e Login

Você pode fazer login usando qualquer um dos usuários de demonstração:

```bash
# Interface web
# Acesse: http://localhost:8000/login
# Use qualquer credencial de usuário de demonstração da tabela acima

# Autenticação API
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "admin@demo.com", "password": "password123"}'
```

### Operações Multi-Tenant

A aplicação suporta operações multi-tenant. Você pode trabalhar com diferentes tenants:

```bash
# Executar worker de fila para um tenant específico
php artisan tenants:run queue:work --tenants=demo-store

# Executar worker de fila para múltiplos tenants
php artisan tenants:run queue:work --tenants=demo-store,test-shop

# Executar worker de fila para todos os tenants
php artisan tenants:run queue:work --all-tenants
```

### Sincronizar Recursos

Sincronize dados com plataformas externas de e-commerce:

```bash
# Sincronizar todos os recursos para um tenant
php artisan tenants:run sync --tenants=demo-store

# Sincronizar tipo específico de recurso
php artisan tenants:run sync --tenants=demo-store --argument="type=receive" --argument="resource=products"

# Sincronizar categorias para múltiplos tenants
php artisan tenants:run sync --tenants=demo-store,test-shop --argument="type=receive" --argument="resource=categories"

# Sincronizar pedidos para todos os tenants
php artisan tenants:run sync --all-tenants --argument="type=receive" --argument="resource=orders"
```

### Integração de Canais

Teste diferentes integrações de plataformas de e-commerce:

```bash
# Testar integração MercadoLivre
php artisan tenants:run --tenants=demo-store channel:test --channel=mercadolivre

# Testar integração WooCommerce  
php artisan tenants:run --tenants=test-shop channel:test --channel=woocommerce

# Testar integração Magento2
php artisan tenants:run --tenants=sample-mart channel:test --channel=magento2
```

## Testes

### Executar Testes
```bash
# Executar todos os testes
php artisan test

# Executar testes com cobertura
php artisan test --coverage

# Executar suite específica de testes
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature
```

### Testando com Dados de Demonstração

A aplicação inclui dados de demonstração abrangentes para testes:

```bash
# Testar funcionalidade multi-tenant
php artisan tenants:run --tenants=demo-store,test-shop,sample-mart test

# Testar operações específicas de tenant
php artisan tenants:run --tenants=demo-store queue:work --once
php artisan tenants:run --tenants=test-shop sync --argument="type=receive" --argument="resource=products"

# Testar endpoints da API com usuários de demonstração
curl -X GET http://localhost:8000/api/v1/users \
  -H "Authorization: Bearer SEU_TOKEN" \
  -H "Content-Type: application/json"
```

### Testes de Banco de Dados
Certifique-se de ter um banco de dados de teste separado configurado no seu arquivo `.env.testing`.

### Dados de Demonstração para Testes

Use as seguintes credenciais de demonstração para testes:

**Usuários:**
- Admin: `admin@demo.com` / `password123`
- Manager: `manager@demo.com` / `password123`
- User: `user@demo.com` / `password123`
- Support: `support@demo.com` / `password123`

**Tenants:**
- `demo-store`
- `test-shop`
- `sample-mart`

## Deploy

### Build de Produção
```bash
# Compilar assets de produção
yarn prod

# Otimizar para produção
php artisan optimize
composer install --optimize-autoloader --no-dev
```

### Deploy Serverless
```bash
# Deploy para AWS Lambda
yarn sls-deploy
```

## Configuração

### Configuração de Canais
Cada canal de e-commerce requer configuração específica. Veja o diretório `config/` para opções disponíveis.

### Mapeamento de Atributos
Personalize mapeamentos de atributos para diferentes plataformas em seus respectivos arquivos de configuração:
- `config/magento2.php` - Mapeamentos de atributos Magento2
- Outras configurações de plataforma conforme necessário

## Solução de Problemas

### Problemas de Conexão com Banco de Dados
1. Certifique-se de que o serviço MySQL está rodando
2. Verifique as credenciais do banco de dados no `.env`
3. Verifique se o banco de dados existe: `mysql -u root -p -e "SHOW DATABASES;"`
4. Execute o script de configuração do banco: `mysql -u root -p < database/setup.sql`

### Problemas de Rotas
Se você encontrar erros de controller não encontrado:
1. Limpe o cache de rotas: `php artisan route:clear`
2. Limpe o cache de configuração: `php artisan config:clear`
3. Regenerar autoload: `composer dump-autoload`

### Problemas de Porta no Windows
Se você encontrar conflitos de porta no Windows:
```powershell
# Visualizar portas reservadas
netsh int ip show excludedportrange protocol=tcp

# Resetar reserva de porta (execute como administrador)
net stop winnat
net start winnat
```

## Documentação da API

A documentação da API está disponível em `/api/documentation` quando a aplicação está rodando.

## Segurança

### Reportar Problemas de Segurança

Se você descobrir uma vulnerabilidade de segurança no FlyHub, envie um email para a equipe de desenvolvimento. Todas as vulnerabilidades de segurança serão prontamente tratadas.

### Configuração de Segurança

- **Variáveis de Ambiente**: Nunca faça commit de arquivos `.env` contendo dados sensíveis
- **Chaves de API**: Rotacione todas as chaves de API regularmente e use variáveis de ambiente
- **Banco de Dados**: Use senhas fortes e habilite SSL em produção
- **Armazenamento de Arquivos**: Configure permissões adequadas do bucket S3 e criptografia

Para diretrizes detalhadas de segurança, veja [SECURITY.md](SECURITY.md).

## Contribuindo

1. Faça um fork do repositório
2. Crie uma branch de feature
3. Faça suas alterações
4. Adicione testes para nova funcionalidade
5. Envie um pull request

### Diretrizes de Segurança para Contribuidores

- Nunca faça commit de dados sensíveis ou chaves de API
- Use variáveis de ambiente para toda configuração
- Siga as melhores práticas de segurança do Laravel
- Teste suas alterações thoroughly

## License

MIT License. [LICENSE](LICENSE)
