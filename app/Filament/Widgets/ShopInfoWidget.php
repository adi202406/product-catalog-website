<?php

namespace App\Filament\Widgets;

use App\Models\ShopInfo;
use App\Models\SocialMedia;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;

class ShopInfoWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.shop-info-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    public ?array $data = [];

    public $url_logo;
    public $name;
    public $description;
    public $address;
    public $phone;
    public $email;
    public $is_open;
    public $message;
    public $social_media;


    public function mount(): void
    {
        $shopInfo = ShopInfo::first();
        
        // Retrieve existing social media accounts
        $socialMedia = $shopInfo 
            ? $shopInfo->socialMedia()->get()->toArray() 
            : [];

        $this->form->fill([
            'name' => $shopInfo?->name ?? '',
            'description' => $shopInfo?->description ?? '',
            'address' => $shopInfo?->address ?? '',
            'phone' => $shopInfo?->phone ?? '',
            'email' => $shopInfo?->email ?? '',
            'is_open' => $shopInfo?->is_open ?? false,
            'message' => $shopInfo?->message ?? 'Toko sedang tutup',
            'url_logo' => $shopInfo?->url_logo ?? '',
            'social_media' => $socialMedia,
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Toko')
                    ->required()
                    ->placeholder('Masukkan Nama Toko')
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi Toko')
                    ->required()
                    ->placeholder('Masukkan Deskripsi Toko')
                    ->autosize(),
                
                TextInput::make('address')
                    ->label('Alamat')
                    ->required()
                    ->placeholder('Masukkan Alamat Toko')
                    ->maxLength(500),
                
                TextInput::make('phone')
                    ->label('Telepon')
                    ->required()
                    ->placeholder('Masukkan Nomor Telepon')
                    ->tel()
                    ->maxLength(20),
                
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->placeholder('Masukkan Email Toko')
                    ->email()
                    ->maxLength(255),
                
                Toggle::make('is_open')
                    ->label('Status Toko')
                    ->helperText('Toggle untuk mengubah status buka/tutup Toko')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check')
                    ->offIcon('heroicon-o-x-mark'),
                
                Textarea::make('message')
                    ->label('Pesan')
                    ->required()
                    ->helperText('Pesan yang akan ditampilkan kepada pelanggan')
                    ->placeholder('Contoh: Toko buka jam 08.00 - 21.00')
                    ->rows(2)
                    ->maxLength(500),
                
                FileUpload::make('url_logo')
                    ->label('Logo Toko')
                    ->disk('public')
                    ->directory('logos')
                    ->visibility('private')
                    ->required()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml'])
                    ->maxSize(5120) // 5MB
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => 
                            'logo-' . uniqid() . '.' . $file->getClientOriginalExtension()
                    )
                    ->image()
                    ->helperText('Unggah logo toko (maks 5MB, format: jpg, png, svg)'),
                
                Repeater::make('social_media')
                    ->label('Akun Media Sosial')
                    ->schema([
                        Select::make('platform')
                            ->label('Platform')
                            ->options([
                                'facebook' => 'Facebook',
                                'instagram' => 'Instagram',
                                'twitter' => 'Twitter',
                                'linkedin' => 'LinkedIn',
                                'youtube' => 'YouTube',
                                'tiktok' => 'TikTok',
                                'whatsapp' => 'WhatsApp',
                            ])
                            ->required()
                            ->searchable(),
                        
                        TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->required()
                            ->placeholder('Masukkan URL lengkap akun media sosial')
                            ->maxLength(255),
                        
                        FileUpload::make('icon')
                            ->label('Icon Sosial Media')
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('private')
                            ->required()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/svg+xml'])
                            ->maxSize(5120) // 5MB
                            ->getUploadedFileNameForStorageUsing(
                                fn (TemporaryUploadedFile $file): string => 
                                    'icon-sosmed' . uniqid() . '.' . $file->getClientOriginalExtension()
                            )
                            ->image()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->helperText('Unggah logo toko (maks 5MB, format: jpg, png, svg)'),
                        
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->orderable()
                    ->defaultItems(0)
                    ->createItemButtonLabel('Tambah Akun Media Sosial')
                    ->maxItems(10),
            ]);
    }
    
    public function submit(): void
    {
        $data = $this->form->getState();
        
        DB::transaction(function () use ($data) {
            // Update or create shop info
            $shopInfo = ShopInfo::first() ?? new ShopInfo();
            $shopInfo->fill([
                'name' => $data['name'],
                'description' => $data['description'],
                'address' => $data['address'] ?? null,
                'phone' => $data['phone'] ?? null,
                'email' => $data['email'] ?? null,
                'is_open' => $data['is_open'],
                'message' => $data['message'],
                'url_logo' => $data['url_logo'],
            ]);
            $shopInfo->save();

            // Handle social media accounts
            // First, remove existing social media accounts
            $shopInfo->socialMedia()->delete();

            // Then add new social media accounts
            if (isset($data['social_media']) && is_array($data['social_media'])) {
                foreach ($data['social_media'] as $socialMedia) {
                    $shopInfo->socialMedia()->create([
                        'platform' => $socialMedia['platform'],
                        'url' => $socialMedia['url'],
                        'icon' => $socialMedia['icon'] ?? null,
                        'is_active' => $socialMedia['is_active'] ?? true,
                    ]);
                }
            }
        });
        
        Notification::make()
            ->title('Berhasil Disimpan')
            ->body('Informasi toko dan media sosial telah diperbarui')
            ->success()
            ->send();
    }
}