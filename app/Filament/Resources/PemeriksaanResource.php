<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemeriksaanResource\Pages;
use App\Filament\Resources\PemeriksaanResource\RelationManagers;
use App\Models\Pemeriksaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PemeriksaanResource extends Resource
{
    protected static ?string $model = Pemeriksaan::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Data Kesehatan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('anak_id')
                    ->relationship('anak', 'nama_anak')
                    ->required(),
                Forms\Components\Select::make('jadwal_posyandu_id')
                    ->relationship('jadwalPosyandu', 'lokasi')
                    ->required(),
                Forms\Components\TextInput::make('berat_badan')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tinggi_badan')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('catatan_medis')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('anak.nama_anak')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jadwalPosyandu.lokasi')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListPemeriksaans::route('/'),
            'create' => Pages\CreatePemeriksaan::route('/create'),
            'edit' => Pages\EditPemeriksaan::route('/{record}/edit'),
        ];
    }
}
