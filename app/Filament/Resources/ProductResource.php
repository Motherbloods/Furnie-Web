<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Seller;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Product Management';
    protected static ?string $navigationGroup = 'Product Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        Select::make('seller_id')
                            ->label('Seller')
                            ->options(function () {
                                return Seller::with('user')
                                    ->get()
                                    ->pluck('store_name', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->searchable(),

                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->required()
                            ->rows(4),

                        Select::make('kategori')
                            ->label('Category')
                            ->options([
                                'sofa' => 'Sofa',
                                'kursi' => 'Kursi',
                                'meja' => 'Meja',
                                'lemari' => 'Lemari',
                                'tempat_tidur' => 'Tempat Tidur',
                                'dekorasi' => 'Dekorasi',
                                'lighting' => 'Lighting',
                                'storage' => 'Storage',
                            ])
                            ->required(),

                        Select::make('status')
                            ->options([
                                'aktif' => 'Aktif',
                                'non-aktif' => 'Non-Aktif',
                                'pending' => 'Pending Review',
                            ])
                            ->required()
                            ->default('aktif'),
                    ])
                    ->columns(2),

                Section::make('Pricing & Stock')
                    ->schema([
                        TextInput::make('original_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('price')
                            ->label('Selling Price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        TextInput::make('discount')
                            ->numeric()
                            ->suffix('%')
                            ->default(0),

                        TextInput::make('stock')
                            ->numeric()
                            ->required()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Rating & Reviews')
                    ->schema([
                        TextInput::make('rating')
                            ->numeric()
                            ->step(0.1)
                            ->minValue(0)
                            ->maxValue(5)
                            ->default(0),

                        TextInput::make('reviews')
                            ->label('Review Count')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Images')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Main Image')
                            ->image()
                            ->directory('products')
                            ->visibility('public')
                            ->hint(function ($state, $record) {
                                if ($record && $record->image) {
                                    $url = str_starts_with($record->image, 'storage/')
                                        ? asset($record->image)
                                        : asset('storage/' . $record->image);
                                    return new HtmlString("
                <div class='mt-2'>
                    <p class='text-sm text-gray-600 mb-1'>Gambar saat ini:</p>
                    <img src='{$url}' alt='Main Image' class='w-32 rounded-xl border border-gray-200 shadow'>
                </div>
            ");
                                }
                                return null;
                            }),

                        Textarea::make('images')
                            ->label('Additional Images (URLs)')
                            ->helperText('Enter image URLs separated by commas')
                            ->placeholder('https://example.com/image1.jpg, https://example.com/image2.jpg')
                            ->rows(3),
                    ]),


                Section::make('Product Details')
                    ->schema([
                        KeyValue::make('specifications')
                            ->keyLabel('Specification')
                            ->valueLabel('Value')
                            ->addActionLabel('Add specification')
                            ->reorderable(),

                        // Updated features field to handle comma-separated string format
                        Textarea::make('features')
                            ->label('Features')
                            ->helperText('Enter features separated by commas')
                            ->placeholder('Feature 1, Feature 2, Feature 3')
                            ->rows(4),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                ImageColumn::make('image')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('seller.store_name')
                    ->label('Store')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('seller.user.name')
                    ->label('Seller Name')
                    ->searchable(),

                TextColumn::make('kategori')
                    ->label('Category')
                    ->badge()
                    ->sortable(),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stock')
                    ->sortable()
                    ->color(fn($state) => $state > 10 ? 'success' : ($state > 0 ? 'warning' : 'danger')),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'non-aktif',
                        'warning' => 'pending',
                    ])
                    ->sortable(),

                TextColumn::make('rating')
                    ->numeric(decimalPlaces: 1)
                    ->sortable(),

                TextColumn::make('reviews')
                    ->label('Reviews')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Category')
                    ->options([
                        'sofa' => 'Sofa',
                        'kursi' => 'Kursi',
                        'meja' => 'Meja',
                        'lemari' => 'Lemari',
                        'tempat_tidur' => 'Tempat Tidur',
                        'dekorasi' => 'Dekorasi',
                        'lighting' => 'Lighting',
                        'storage' => 'Storage',
                    ]),

                SelectFilter::make('status')
                    ->options([
                        'aktif' => 'aktif',
                        'nonaktif' => 'non-aktif',
                        'pending' => 'Pending Review',
                    ]),

                SelectFilter::make('seller_id')
                    ->label('Seller')
                    ->options(function () {
                        return Seller::with('user')
                            ->get()
                            ->pluck('store_name', 'id')
                            ->toArray();
                    })
                    ->searchable(),

                Tables\Filters\Filter::make('low_stock')
                    ->label('Low Stock (≤10)')
                    ->query(fn(Builder $query): Builder => $query->where('stock', '<=', 10)),

                Tables\Filters\Filter::make('out_of_stock')
                    ->label('Out of Stock')
                    ->query(fn(Builder $query): Builder => $query->where('stock', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Action::make('toggle_status')
                    ->label(fn(Product $record) => $record->status === 'aktif' ? 'Deactivate' : 'Activate')
                    ->icon(fn(Product $record) => $record->status === 'aktif' ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn(Product $record) => $record->status === 'aktif' ? 'danger' : 'success')
                    ->visible(fn(Product $record): bool => in_array($record->status, ['aktif', 'non-aktif']))
                    ->action(function (Product $record) {
                        $newStatus = $record->status === 'aktif' ? 'non-aktif' : 'aktif';
                        $record->update(['status' => $newStatus]);
                        Notification::make()
                            ->title("Product {$newStatus}")
                            ->success()
                            ->send();
                    }),

                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['status' => 'aktif']);
                            });
                            Notification::make()
                                ->title('Selected products approved')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}