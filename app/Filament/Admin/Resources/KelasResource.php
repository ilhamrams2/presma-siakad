<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KelasResource\Pages;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $modelLabel = 'Kelas';
    protected static ?string $pluralModelLabel = 'Kelas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->required(),

                Forms\Components\Select::make('wali_kelas_id')
                    ->label('Wali Kelas')
                    ->relationship('waliKelas', 'nama')
                    ->nullable(),

                Forms\Components\TextInput::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('waliKelas')
                    ->label('Wali Kelas')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        // Gabungkan nama dan gelar
                        return $record->waliKelas ? $record->waliKelas->nama . ' ' . $record->waliKelas->gelar : '-';
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Dibuat')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            // bisa tambahkan RelationManager nanti kalau mau relasi siswa
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getNavigationSort(): ?int
    {
        return 2; // posisi di bawah Jurusan
    }
}
