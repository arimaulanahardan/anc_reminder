<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-filament::section>
            <x-slot name="heading">
                Connection Status
            </x-slot>

            <div class="flex flex-col items-center justify-center space-y-4 p-4">
                <div class="text-lg font-medium">
                    Current Status: 
                    <span @class([
                        'font-bold',
                        'text-success-600' => $status === 'connected',
                        'text-warning-600' => $status === 'connecting',
                        'text-danger-600' => $status === 'disconnected' || $status === 'error',
                    ])>
                        {{ ucfirst($status) }}
                    </span>
                </div>

                <div class="text-sm text-gray-500">
                    Last Updated: {{ $lastUpdated }}
                </div>

                @if($status === 'connected')
                    <div class="flex flex-col items-center space-y-2">
                        <div style="width: 50px; height: 50px;">
                            <x-heroicon-o-check-circle class="w-4 h-4 text-success-500" />
                        </div>
                        <p class="text-success-600">WhatsApp is connected and ready to send messages.</p>
                        
                        <x-filament::button wire:click="disconnect" color="danger" class="mt-4">
                            Disconnect
                        </x-filament::button>
                    </div>
                @else
                    <div class="flex flex-col items-center space-y-4">
                        @if($qrCode)
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <img src="{{ $qrCode }}" alt="WhatsApp QR Code" class="w-64 h-64" />
                            </div>
                            <p class="text-sm text-gray-600 text-center">
                                Scan this QR code with your WhatsApp app to connect.<br>
                                (Settings > Linked Devices > Link a Device)
                            </p>
                        @else
                        <div style="width: 50px; height: 50px;">
                            <x-heroicon-o-qr-code class="w-4 h-4 text-gray-400" />
                        </div>
                            <p class="text-gray-500">No QR code generated yet.</p>
                        @endif

                        <x-filament::button wire:click="connect" color="primary">
                            {{ $qrCode ? 'Refresh QR Code' : 'Generate QR Code' }}
                        </x-filament::button>
                    </div>
                @endif
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">
                Instructions
            </x-slot>

            <div class="prose dark:prose-invert">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Open WhatsApp on your phone.</li>
                    <li>Go to <strong>Settings</strong> (or Menu on Android).</li>
                    <li>Select <strong>Linked Devices</strong>.</li>
                    <li>Tap <strong>Link a Device</strong>.</li>
                    <li>Point your phone at the QR code on this screen.</li>
                </ol>

                <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <h4 class="font-medium mb-2">Troubleshooting</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <li>If the QR code expires, click "Refresh QR Code".</li>
                        <li>Ensure your phone has an active internet connection.</li>
                        <li>If messages are not sending, try disconnecting and reconnecting.</li>
                    </ul>
                </div>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
