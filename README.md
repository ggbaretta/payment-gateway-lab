# Payment Gateway API

API de gateway de pagamentos desenvolvida em Laravel 12 com suporte a webhooks para notificação de transações.

## Requisitos

- PHP 8.2+
- Composer
- Node.js & NPM
- Postgres SQl

## Instalação

```bash
# Clone o repositório
git clone <url-do-repositorio>
cd <nome-do-projeto>

# Instale as dependências e configure o projeto
composer setup
```

O comando `composer setup` executa automaticamente:
- Instalação das dependências PHP e Node
- Criação do arquivo `.env`
- Geração da chave da aplicação
- Execução das migrations
- Build dos assets

## Executando o Projeto

```bash
composer dev
```

Este comando inicia simultaneamente:
- Servidor PHP (`php artisan serve`)
- Worker de filas
- Logs em tempo real (Pail)
- Vite para assets

## API

### Criar Pagamento

```http
POST /api/payments
Content-Type: application/json

{
    "amount": 100.00,
    "webhook_url": "https://seu-servidor.com/webhook"
}
```

**Resposta:**
```json
{
    "message": "Pagamento processado",
    "transaction_id": "uuid-da-transacao"
}
```

### Webhook

Após processar o pagamento, a API envia uma notificação para a `webhook_url` informada:

```json
{
    "id": "uuid-da-transacao",
    "status": "approved",
    "amount": 100.00
}
```

O webhook inclui o header `X-Gateway-Signature` com assinatura HMAC-SHA256 para validação.

## Estrutura do Projeto

```
app/
├── Http/Controllers/
│   └── PaymentController.php    # Controller de pagamentos
├── Models/
│   └── Transaction.php          # Model de transações
└── Services/
    └── WebhookSenderService.php # Serviço de envio de webhooks
```

## Testes

```bash
composer test
```

## Configuração

Variáveis de ambiente importantes no `.env`:

| Variável | Descrição |
|----------|-----------|
| `APP_KEY` | Chave da aplicação (gerada automaticamente) |
| `DB_CONNECTION` | Driver do banco de dados (padrão: pgsql) |
| `QUEUE_CONNECTION` | Driver de filas (padrão: database) |

## Licença

MIT
