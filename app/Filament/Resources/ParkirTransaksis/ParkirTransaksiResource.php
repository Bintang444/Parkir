<?php

namespace App\Filament\Resources\ParkirTransaksis;

use App\Filament\Resources\ParkirTransaksis\Pages\CreateParkirTransaksi;
use App\Filament\Resources\ParkirTransaksis\Pages\EditParkirTransaksi;
use App\Filament\Resources\ParkirTransaksis\Pages\ListParkirTransaksis;
use App\Filament\Resources\ParkirTransaksis\Schemas\ParkirTransaksiForm;
use App\Filament\Resources\ParkirTransaksis\Tables\ParkirTransaksisTable;
use App\Models\ParkirTransaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParkirTransaksiResource extends Resource
{
    protected static ?string $model = ParkirTransaksi::class;

    // ✅ BENAR
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // ✅ BENAR (string biasa)
    protected static ?string $navigationLabel = 'Parkir Transaksi';

    // ✅ BENAR (boleh string|UnitEnum|null)
    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Parkir';

    protected static ?string $recordTitleAttribute = 'card_id';

    // ✅ sementara true dulu biar pasti muncul
    public static function canViewAny(): bool
    {
        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return ParkirTransaksiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParkirTransaksisTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParkirTransaksis::route('/'),
            'create' => CreateParkirTransaksi::route('/create'),
            'edit' => EditParkirTransaksi::route('/{record}/edit'),
        ];
    }
}