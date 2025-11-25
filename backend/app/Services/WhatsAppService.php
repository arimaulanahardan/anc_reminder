<?php

namespace App\Services;

use App\Models\WhatsAppConnection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.whatsapp.url', env('WHATSAPP_SERVICE_URL', 'http://localhost:3000'));
        $this->apiKey = config('services.whatsapp.key', env('WHATSAPP_API_KEY'));
    }

    public function getConnectionStatus()
    {
        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->get("{$this->baseUrl}/api/status");

            $data = $response->json();

            // Update Database
            $connection = WhatsAppConnection::firstOrCreate([], ['is_connected' => false]);
            
            if (isset($data['status'])) {
                $isConnected = $data['status'] === 'connected';
                $connection->update([
                    'is_connected' => $isConnected,
                    'qr_code' => $isConnected ? null : ($data['qr_code'] ?? null),
                    'connected_at' => $isConnected ? ($connection->connected_at ?? now()) : null,
                    'disconnected_at' => !$isConnected ? ($connection->disconnected_at ?? now()) : null,
                ]);
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Error (Status): ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getQRCode()
    {
        set_time_limit(120);
        try {
            $response = Http::timeout(60)->withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->post("{$this->baseUrl}/api/connect");

            $data = $response->json();

            // Update Database
            if (isset($data['qr_code'])) {
                WhatsAppConnection::updateOrCreate(
                    [], // Update first record or create new
                    [
                        'qr_code' => $data['qr_code'],
                        'is_connected' => false,
                        'disconnected_at' => now(),
                    ]
                );
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Error (Connect): ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function sendMessage($phone, $message, $reminderId = null)
    {
        set_time_limit(120);
        try {
            $response = Http::timeout(60)->withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->post("{$this->baseUrl}/api/send", [
                'phone' => $phone,
                'message' => $message,
                'reminderId' => $reminderId,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Error (Send): ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    public function disconnect()
    {
        set_time_limit(120);
        try {
            $response = Http::timeout(60)->withHeaders([
                'X-API-Key' => $this->apiKey,
            ])->post("{$this->baseUrl}/api/disconnect");

            $data = $response->json();

            if ($data['success'] ?? false) {
                // Update Database
                WhatsAppConnection::updateOrCreate(
                    [],
                    [
                        'is_connected' => false,
                        'qr_code' => null,
                        'connected_at' => null,
                        'disconnected_at' => now(),
                    ]
                );
            }

            return $data;
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Error (Disconnect): ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
