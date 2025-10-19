<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MapelResource\Pages;
use App\Filament\Admin\Resources\MapelResource\RelationManagers;
use App\Models\Mapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MapelResource extends Resource
{
    protected static ?string $model = Mapel::class;

    protected static ?string $modelLabel = 'Mapel';
    protected static ?string $pluralModelLabel = 'Mapel';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guru_id')
                    ->required()
                    ->numeric()
                    ->relationship('guru', 'nama'),
                Forms\Components\TextInput::make('nama_mapel')
                    ->required()
                    ->maxLength(255)
                    ->relationship('guru', 'nama'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guru_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_mapel')
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
            'index' => Pages\ListMapels::route('/'),
            'create' => Pages\CreateMapel::route('/create'),
            'edit' => Pages\EditMapel::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }
    
    public static function getNavigationSort(): ?int
    {
        return 3; // Paling atas di grup Akademik
    } 
}
