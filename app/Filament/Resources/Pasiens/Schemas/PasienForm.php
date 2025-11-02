<?php

namespace App\Filament\Resources\Pasiens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PasienForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
                TextInput::make('no_hp')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('keterangan')
                    ->required(),
                DatePicker::make('terdaftar')
                    ->required(),
                TextInput::make('usia_kehailan')
                    ->required()
                    ->numeric(),
                Select::make('jenis_kelamin')
                    ->options(['Laki-laki' => 'Laki laki', 'Perempuan' => 'Perempuan'])
                    ->required(),
            ]);
    }
}
