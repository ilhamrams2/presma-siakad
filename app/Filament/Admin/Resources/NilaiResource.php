<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NilaiResource\Pages;
use App\Filament\Admin\Resources\NilaiResource\RelationManagers;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $modelLabel = 'Nilai';
    protected static ?string $pluralModelLabel = 'Nilai';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Pilih Kelas dulu
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->required()
                    ->options(Kelas::pluck('nama_kelas', 'id'))
                    ->reactive() // biar dependent dropdown bekerja
                    ->afterStateUpdated(fn($set) => $set('siswa_id', null)),

                // Pilih siswa dari kelas terpilih
                Select::make('siswa_id')
                    ->label('Nama Siswa')
                    ->required()
                    ->options(function ($get) {
                        $kelasId = $get('kelas_id');
                        if (!$kelasId) return [];
                        return Siswa::where('kelas_id', $kelasId)
                            ->with('user')
                            ->get()
                            ->mapWithKeys(fn($siswa) => [$siswa->id => $siswa->user->name])
                            ->toArray();
                    })
                    ->searchable(),

                // Pilih mapel milik guru login
                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->required()
                    ->options(function () {
                        $guruId = auth()->id();
                        return Mapel::where('guru_id', $guruId)
                            ->pluck('nama_mapel', 'id')
                            ->toArray();
                    }),

                // Input nilai
                TextInput::make('nilai')
                    ->required()
                    ->numeric()
                    ->default(0.00),

                TextInput::make('semester')
                    ->label('Semester')
                    ->maxLength(20),

                TextInput::make('tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->maxLength(20),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mapel_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_ajaran')
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
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getNavigationSort(): ?int
    {
        return 5; // Paling atas di grup Akademik
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Cek kalau user login adalah guru
        if (Auth::check() && Auth::user()->role === 'guru') {
            $guruId = Auth::id(); // id user guru
            $query->whereHas('mapel', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            });
        }

        return $query;
    }
}
