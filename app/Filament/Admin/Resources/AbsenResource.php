<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AbsenResource\Pages;
use App\Filament\Admin\Resources\AbsenResource\RelationManagers;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsenResource extends Resource
{
    protected static ?string $model = Absen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('kelas_id')
                    ->label('Kelas')
                    ->required()
                    ->options(Kelas::pluck('nama_kelas', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn($set) => $set('siswa_id', null)),

                Select::make('siswa_id')
                    ->label('Siswa')
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

                Select::make('mapel_id')
                    ->label('Mata Pelajaran')
                    ->required()
                    ->options(Mapel::pluck('nama_mapel', 'id')->toArray())
                    ->searchable(),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                Select::make('status')
                    ->label('Status')
                    ->required()
                    ->options([
                        'Hadir' => 'Hadir',
                        'Sakit' => 'Sakit',
                        'Izin'  => 'Izin',
                        'Alpha' => 'Alpha',
                    ])
                    ->default('Hadir')
                    ->searchable(false), // optional, karena daftar pendek
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.user.name')->label('Siswa')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas')->sortable(),
                Tables\Columns\TextColumn::make('mapel.nama_mapel')->label('Mapel')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelas_id')->relationship('kelas', 'nama_kelas'),
                Tables\Filters\SelectFilter::make('mapel_id')->relationship('mapel', 'nama_mapel'),
                Tables\Filters\SelectFilter::make('status')->options([
                    'Hadir' => 'Hadir',
                    'Sakit' => 'Sakit',
                    'Izin' => 'Izin',
                    'Alpha' => 'Alpha',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListAbsens::route('/'),
            'create' => Pages\CreateAbsen::route('/create'),
            'edit' => Pages\EditAbsen::route('/{record}/edit'),
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Akademik';
    }

    public static function getNavigationSort(): ?int
    {
        return 7; // Paling atas di grup Akademik
    }
}
