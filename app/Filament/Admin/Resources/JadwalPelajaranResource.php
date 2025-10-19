<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JadwalPelajaranResource\Pages;
use App\Filament\Admin\Resources\JadwalPelajaranResource\RelationManagers;
use App\Models\JadwalPelajaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JadwalPelajaranResource extends Resource
{
    protected static ?string $model = JadwalPelajaran::class;

    protected static ?string $modelLabel = 'Jadwal Pelajaran';
    protected static ?string $pluralModelLabel = 'Jadwal Pelajaran';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
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
            'index' => Pages\ListJadwalPelajarans::route('/'),
            'create' => Pages\CreateJadwalPelajaran::route('/create'),
            'edit' => Pages\EditJadwalPelajaran::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getNavigationSort(): ?int
    {
        return 6; // Paling atas di grup Akademik
    }
}
