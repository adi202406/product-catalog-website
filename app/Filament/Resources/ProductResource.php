<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->placeholder('Masukkan nama produk')
                ->maxLength(255),
            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),

            // Repeater untuk langsung membuat tipe produk
            Repeater::make('types')
                ->relationship()
                ->schema([
                    TextInput::make('name')
                        ->placeholder('Masukkan nama tipe produk')
                        ->required()
                        ->label('Tipe Produk'),
                    Textarea::make('description')
                        ->autosize()
                        ->placeholder('Masukkan deskripsi produk type ini')
                        ->maxLength(255),
                    TextInput::make('price')
                        ->prefix('Rp')
                        ->placeholder('Masukkan harga untuk tipe ini')
                        ->required()
                        ->numeric(),
                    TextInput::make('promo_price')
                        ->prefix('Rp')
                        ->placeholder('Masukkan harga promo untuk tipe ini')
                        ->numeric(),
                    Toggle::make('is_available')
                        ->label('Tersedia?')
                        ->helperText('Apakah produk tersedia?')
                        ->default(true)
                        ->required(),

                    // Repeater untuk menyimpan gambar per tipe
                    Repeater::make('images')
                        ->relationship()
                        ->schema([
                            FileUpload::make('url')
                                ->label('Gambar')
                                ->image()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imageResizeTargetWidth('1920')
                                ->imageResizeTargetHeight('1080')
                                ->disk('public')
                                ->directory('types/image/product')
                                ->visibility('public')
                                ->required()
                        ])
                        ->addActionLabel('Tambah Gambar')
                        ->collapsible()
                        ->maxItems(5)
                        ->columnSpanFull(),
                ])
                ->label('Tipe Produk')
                ->addActionLabel('Tambah Tipe Produk')
                ->collapsible(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('types.description')
                ->label('Deskripsi')
                ->listWithLineBreaks()
                ->bulleted()
                ->searchable(),
            TextColumn::make('types.name')
                ->searchable()
                ->sortable()
                ->listWithLineBreaks()
                ->bulleted(),
            TextColumn::make('types.price')
                ->money('idr')
                ->listWithLineBreaks()
                ->bulleted()
                ->sortable(),
            TextColumn::make('types.is_available')
                ->label('Tersedia?')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                ->listWithLineBreaks()
                ->bulleted()
                ->sortable(),
            TextColumn::make('category.name')
                ->searchable()
                ->sortable(),
            ImageColumn::make('types.images.url')
                ->circular()
                ->stacked()
                ->limit(3),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(), 
                Tables\Actions\DeleteAction::make(),  
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
