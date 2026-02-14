<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\WebhookSenderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller {
    public function store(Request $request, WebhookSenderService $webhookService) {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'webhook_url' => 'required|url',
        ]);

        $transaction = Transaction::create([
            'external_id' => Str::uuid(),
            'amount' => $data['amount'],
            'status' => 'approved', // Simulando aprovação automática
            'webhook_url' => $data['webhook_url']
        ]);

        $webhookService->send($transaction->webhook_url, [
            'id' => $transaction->external_id,
            'status' => $transaction->status,
            'amount' => $transaction->amount
        ]);

        return response()->json([
            'message' => 'Pagamento processado',
            'transaction_id' => $transaction->external_id
        ], 201);
    }
}