<?php

namespace App\Filament\Resources\Reminders\Tables;

use App\Models\Reminder;
use App\Services\WhatsAppService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class RemindersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.name')
                    ->label('Patient')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.phone_number')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('scheduled_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'sending' => 'warning',
                        'sent' => 'success',
                        'failed' => 'danger',
                    }),
                TextColumn::make('sent_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('send_now')
                    ->label('Send Now')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Reminder $record, WhatsAppService $whatsAppService) {
                        $record->update(['status' => 'sending']);
                        
                        $result = $whatsAppService->sendMessage(
                            $record->patient->phone_number,
                            $record->message,
                            $record->id
                        );

                        if ($result['success'] ?? false) {
                            $record->update([
                                'status' => 'sent',
                                'sent_at' => now(),
                                'error_message' => null,
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Reminder sent successfully')
                                ->success()
                                ->send();
                        } else {
                            $record->update([
                                'status' => 'failed',
                                'error_message' => $result['error'] ?? 'Unknown error',
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Failed to send reminder')
                                ->body($result['error'] ?? 'Unknown error')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn (Reminder $record) => $record->status !== 'sent'),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
