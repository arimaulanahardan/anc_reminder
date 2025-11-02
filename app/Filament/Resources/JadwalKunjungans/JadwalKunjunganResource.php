<?php

namespace App\Filament\Resources\JadwalKunjungans;

use App\Filament\Resources\JadwalKunjungans\Pages\CreateJadwalKunjungan;
use App\Filament\Resources\JadwalKunjungans\Pages\EditJadwalKunjungan;
use App\Filament\Resources\JadwalKunjungans\Pages\ListJadwalKunjungans;
use App\Filament\Resources\JadwalKunjungans\Schemas\JadwalKunjunganForm;
use App\Filament\Resources\JadwalKunjungans\Tables\JadwalKunjungansTable;
use App\Models\JadwalKunjungan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JadwalKunjunganResource extends Resource
{
    protected static ?string $model = JadwalKunjungan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'pasien.nama';

    public static function form(Schema $schema): Schema
    {
        return JadwalKunjunganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JadwalKunjungansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwalKunjungans::route('/'),
            'create' => CreateJadwalKunjungan::route('/create'),
            'edit' => EditJadwalKunjungan::route('/{record}/edit'),
        ];
    }
}
