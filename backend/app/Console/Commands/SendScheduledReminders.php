<?php

namespace App\Console\Commands;

use App\Models\Reminder;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendScheduledReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled WhatsApp reminders';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsAppService)
    {
        $reminders = Reminder::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->with('patient')
            ->get();

        if ($reminders->isEmpty()) {
            $this->info('No pending reminders to send.');
            return;
        }

        $this->info("Found {$reminders->count()} reminders to send.");

        foreach ($reminders as $reminder) {
            if (!$reminder->patient) {
                $reminder->update([
                    'status' => 'failed',
                    'error_message' => 'Patient not found',
                ]);
                continue;
            }

            $this->info("Sending reminder to {$reminder->patient->name} ({$reminder->patient->phone_number})...");
            
            $reminder->update(['status' => 'sending']);

            $result = $whatsAppService->sendMessage(
                $reminder->patient->phone_number,
                $reminder->message,
                $reminder->id
            );

            if ($result['success'] ?? false) {
                $reminder->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'error_message' => null,
                ]);
                $this->info("Reminder sent successfully.");
            } else {
                $reminder->update([
                    'status' => 'failed',
                    'error_message' => $result['error'] ?? 'Unknown error',
                ]);
                $this->error("Failed to send reminder: " . ($result['error'] ?? 'Unknown error'));
            }
        }
    }
}
