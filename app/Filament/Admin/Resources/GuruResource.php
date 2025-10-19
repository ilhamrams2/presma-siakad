<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GuruResource\Pages;
use App\Filament\Admin\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $modelLabel = 'Guru';
    protected static ?string $pluralModelLabel = 'Guru';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nip')
                    ->label('NIP')
                    ->disabled() // biar user nggak bisa isi manual
                    ->dehydrated(true) // tetap disimpan ke database
                    ->default(fn() => '' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT))
                    ->helperText('NIP otomatis dibuat oleh sistem'),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255)
                    ->debounce(500)
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Buat username dari nama tanpa spasi dan huruf kecil semua
                        $username = Str::of($state)->lower()->replace(' ', '');
                        // Set email otomatis
                        $set('email', "{$username}@smkprestasiprima.sch.id");
                    }),

                Forms\Components\TextInput::make('gelar')
                    ->label('Gelar')
                    ->placeholder('Contoh: S.Kom, M.Kom')
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('Email Sekolah (Otomatis)')
                    ->readOnly()
                    ->maxLength(255),
                Forms\Components\TextInput::make('telepon')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->label('Jenis Kelamin')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(), // otomatis kasih nomor urut
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
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
