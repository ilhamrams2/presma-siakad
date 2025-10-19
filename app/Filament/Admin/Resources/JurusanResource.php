<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JurusanResource\Pages;
use App\Filament\Admin\Resources\JurusanResource\RelationManagers;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $modelLabel = 'Jurusan';
    protected static ?string $pluralModelLabel = 'Jurusan';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_jurusan')
                    ->label('Nama Jurusan')
                    ->required()
                    ->maxLength(255)
                    ->debounce(1500)
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Kata-kata yang diabaikan
                        $ignore = ['dan', 'atau', 'di', 'ke', 'dari'];

                        // Pecah kata, ambil huruf pertama kecuali kata di-ignore
                        $kode = collect(explode(' ', $state))
                            ->reject(fn($word) => in_array(strtolower($word), $ignore))
                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                            ->join('');

                        $set('kode_jurusan', $kode);
                    }),

                Forms\Components\TextInput::make('kode_jurusan')
                    ->label('Kode Jurusan')
                    ->required()
                    ->maxLength(10)
                    ->readOnly(),
                Forms\Components\Textarea::make('keterangan')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getNavigationSort(): ?int
    {
        return 1; // Paling atas di grup Akademik
    }
}
