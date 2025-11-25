<?php

namespace App\Filament\Pages;

use App\Services\WhatsAppService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class WhatsAppConnection extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';
    
    protected static ?string $navigationLabel = 'WhatsApp Connection';

    protected string $view = 'filament.pages.whats-app-connection';

    public $status = 'disconnected';
    public $qrCode = null;
    public $lastUpdated = null;

    public function mount(WhatsAppService $whatsAppService)
    {
        $this->refreshStatus($whatsAppService);
    }

    public function refreshStatus(WhatsAppService $whatsAppService)
    {
        $response = $whatsAppService->getConnectionStatus();
        
        $this->status = $response['status'] ?? 'error';
        $this->qrCode = $response['qr_code'] ?? null;
        $this->lastUpdated = now()->format('H:i:s');
    }

    public function connect(WhatsAppService $whatsAppService)
    {
        $response = $whatsAppService->getQRCode();
        
        if ($response['success'] ?? false) {
            $this->qrCode = $response['qr_code'] ?? null;
            $this->status = 'connecting';
            Notification::make()
                ->title('QR Code generated')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to generate QR Code')
                ->body($response['error'] ?? 'Unknown error')
                ->danger()
                ->send();
        }
        
        $this->refreshStatus($whatsAppService);
    }

    public function disconnect(WhatsAppService $whatsAppService)
    {
        $response = $whatsAppService->disconnect();
        
        if ($response['success'] ?? false) {
            Notification::make()
                ->title('Disconnected successfully')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to disconnect')
                ->body($response['error'] ?? 'Unknown error')
                ->danger()
                ->send();
        }
        
        $this->refreshStatus($whatsAppService);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Status')
                ->action(fn (WhatsAppService $service) => $this->refreshStatus($service)),
        ];
    }
}
