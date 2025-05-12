<?php
namespace App\Filament\Resources;

use App\Filament\Resources\QueueResource\Pages;
use App\Models\Queue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QueueResource extends Resource
{
    protected static ?string $model = Queue::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Kode Antrian')
                    ->disabled()
                    ->default(fn() => 'Q-' . strtoupper(uniqid())),

                TextInput::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->required(),

                TextInput::make('no_wa')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->nullable(),

                Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai'  => 'Selesai',
                    ])
                    ->default('diproses')
                    ->required(),

                Repeater::make('items')
                    ->label('Daftar Barang')
                    ->relationship()
                    ->schema([
                        TextInput::make('item_name')
                            ->label('Nama Barang')
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->required(),
                    ])
                    ->defaultItems(1)
                    ->columns(3)
                    ->createItemButtonLabel('Tambah Barang'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Kode'),
                Tables\Columns\TextColumn::make('customer_name')->label('Pelanggan'),
                Tables\Columns\TextColumn::make('no_wa')->label('No WA'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', true), // true untuk pakai ribuan, atau pakai ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state))
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('whatsapp')
                    ->label('Kirim WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function ($record) {
                        if (! $record->no_wa) {
                            return null;
                        }

                        $message        = "Halo {$record->customer_name}, ";
                        $formattedPrice = "Rp " . number_format($record->total_price, 0, ',', '.');

                        switch (strtolower($record->status)) {
                            case 'menunggu':
                                $message .= "Terima kasih telah melakukan pemesanan dengan kode *{$record->code}*. " .
                                    "Total pesanan Anda adalah *{$formattedPrice}*. " .
                                    "Mohon segera lakukan pembayaran agar pesanan dapat kami proses. " .
                                    "Jika sudah melakukan pembayaran, mohon konfirmasi kepada kami. Terima kasih!";
                                break;

                            case 'diproses':
                                $message .= "Pesanan Anda dengan kode *{$record->code}* " .
                                    "*SEDANG KAMI PROSES*. Total pesanan *{$formattedPrice}*. " .
                                    "Kami akan segera mengirimkan pesanan Anda dan memberikan informasi pengiriman. " .
                                    "Terima kasih atas kesabaran Anda!";
                                break;

                            case 'selesai':
                                $message .= "Pesanan Anda dengan kode *{$record->code}* " .
                                    "*TELAH SELESAI DIPROSES*. Total pesanan *{$formattedPrice}*. " .
                                    "Terima kasih telah berbelanja dengan kami! " .
                                    "Kami harap Anda puas dengan produk dan layanan kami. " .
                                    "Jangan ragu untuk menghubungi kami jika ada pertanyaan.";
                                break;

                            default:
                                $message .= "Pesanan Anda dengan kode *{$record->code}* " .
                                    "dengan total *{$formattedPrice}* " .
                                    "berstatus *{$record->status}*. " .
                                    "Terima kasih telah berbelanja dengan kami!";
                        }

                        $encodedMessage = urlencode($message);
                        return "https://wa.me/{$record->no_wa}?text={$encodedMessage}";
                    })
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->no_wa), // tampilkan hanya jika ada nomor WA
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
            'index'  => Pages\ListQueues::route('/'),
            'create' => Pages\CreateQueue::route('/create'),
            'edit'   => Pages\EditQueue::route('/{record}/edit'),
        ];
    }
}
