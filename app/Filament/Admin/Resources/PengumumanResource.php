<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengumumanResource\Pages;
use App\Filament\Admin\Resources\PengumumanResource\RelationManagers;
use App\Models\Pengumuman;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static ?string $navigationLabel = 'Pengumuman';
    protected static ?string $pluralModelLabel = 'Pengumuman'; // ✅ penting biar tidak plural aneh
    protected static ?string $modelLabel = 'Pengumuman';
    protected static ?string $navigationGroup = 'Informasi';

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Field hidden untuk ID user yang membuat
                Hidden::make('dibuat_oleh')
                    ->default(fn() => auth()->id())
                    ->required(),

                // Field readonly untuk menampilkan nama user
                TextInput::make('nama_user')
                    ->label('Dibuat Oleh')
                    ->default(fn() => auth()->user()->name)
                    ->disabled() // readonly
                    ->dehydrated(false), // jangan ikut submit

                // Judul pengumuman
                TextInput::make('judul')
                    ->required()
                    ->maxLength(255),

                // Keterangan / isi pengumuman
                RichEditor::make('isi')
                    ->label('Keterangan / Catatan')
                    ->required()
                    ->columnSpan('full'),

                // Tanggal pengumuman
                DatePicker::make('tanggal')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pembuat.name') // ambil relasi user dan field name
                    ->label('Dibuat Oleh')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListPengumumen::route('/'),
            'create' => Pages\CreatePengumuman::route('/create'),
            'edit' => Pages\EditPengumuman::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Informasi';
    }

    public static function getNavigationSort(): ?int
    {
        return 1; // Paling atas di grup Informasi
    }
}
