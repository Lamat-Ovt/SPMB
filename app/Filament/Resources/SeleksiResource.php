<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SeleksiResource\Pages;
use App\Filament\Resources\SeleksiResource\RelationManagers;
use App\Models\Seleksi;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\Actions\Action;
use Filament\Notifications\Notification; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Periode;

class SeleksiResource extends Resource
{
    protected static ?string $model = Seleksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id_periode')
                    ->label('Periode')
                    ->default(Periode::where("aktif",1)->pluck('id')->first())
                    ->disabled(),
                    
                
                    //->numeric()
                    //->minValue(2023),
                  
                Forms\Components\TextInput::make('tahap')
                    ->label('Tahap')
                    ->required()
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->displayFormat('d/m/Y')
                    ->required(),
                Forms\Components\TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('id_periode'),
                Tables\Columns\TextColumn::make('tahap'),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSeleksis::route('/'),
            'create' => Pages\CreateSeleksi::route('/create'),
            'edit' => Pages\EditSeleksi::route('/{record}/edit'),
        ];
    } 
        //     public function mount(): void
        // {
        // //tolak akses halaman jika user tidak memiliki role 'Pendaftar'
        // abort_unless(
        // Auth::user()->hasRole('Admin'), 
        // 403
        // );
        // //ambil periode aktif
        // $periode = Periode::where("aktif",1)->first();
        // //ambil data formulir dari periode dan user yang login
        // // $seleksi = Seleksi::where("id_periode", $periode->id)
        // // ->where("id_user", Auth::user()->id)
        // // ->first();
        // //jika tidak ada data formulir, maka buat data awal periode dan nama
        // if (!$seleksi) {
        // $data_awal = [
        // 'id_periode' => $periode->id,
        // 'nama' => Auth::user()->name
        // ];
        // } else {
        // $data_awal = $seleksi ->toArray(); //data awal pakai data di database
        // }
        // $this->form->fill($data_awal); //data awal dimasukkan ke form
        // }
}
