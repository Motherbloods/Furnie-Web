<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\KeyValueEntry;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        // dd($this->record->features, $this->record->images);
        return $infolist
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('description'),
                        TextEntry::make('seller.store_name')->label('Store Name'),
                        TextEntry::make('kategori')->label('Category')->badge(),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'aktif' => 'success',
                                'non-aktif' => 'danger',
                                'pending' => 'warning',
                            }),
                    ])
                    ->columns(2),

                Section::make('Pricing & Stock')
                    ->schema([
                        TextEntry::make('original_price')->money('IDR'),
                        TextEntry::make('price')->label('Selling Price')->money('IDR'),
                        TextEntry::make('discount')->suffix('%'),
                        TextEntry::make('stock'),
                        TextEntry::make('rating')->numeric(decimalPlaces: 1),
                        TextEntry::make('reviews')->label('Review Count'),
                    ])
                    ->columns(2),

                Section::make('Images')
                    ->schema([
                        ImageEntry::make('image')->label('Main Image'),

                        TextEntry::make('images')
                            ->label('Additional Images')
                            ->formatStateUsing(function ($state) {
                                if (empty($state)) {
                                    return 'No additional images';
                                }

                                // Pisahkan berdasarkan koma jika string
                                $images = is_string($state) ? explode(',', $state) : $state;

                                // Bersihkan spasi yang mungkin ada
                                $images = array_map('trim', $images);

                                if (!is_array($images)) {
                                    return 'Invalid image data';
                                }

                                $imageHtml = '';
                                foreach ($images as $index => $image) {
                                    $imageHtml .= '<div class="mb-2">';
                                    $imageHtml .= '<img src="' . $image . '" alt="Image ' . ($index + 1) . '" class="max-w-xs h-auto rounded shadow">';
                                    $imageHtml .= '</div>';
                                }

                                return new \Illuminate\Support\HtmlString($imageHtml);
                            }),
                    ]),

                Section::make('Product Details')
                    ->schema([
                        KeyValueEntry::make('specifications')
                            ->keyLabel('Specification')
                            ->valueLabel('Value'),

                        TextEntry::make('features')
                            ->label('Features')
                            ->formatStateUsing(function ($state) {
                                if (empty($state)) {
                                    return 'No features';
                                }

                                $features = is_string($state) ? explode(',', $state) : $state;
                                $features = array_map('trim', $features);

                                $html = '
            <div class="w-full overflow-x-auto">
                <div class="min-w-full border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full text-sm text-gray-800">
                        <thead class="bg-black text-left text-sm font-semibold text-white">
                            <tr>
                                <th class="px-4 py-3 border-b w-16">#</th>
                                <th class="px-4 py-3 border-b">Feature</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
        ';

                                foreach ($features as $index => $feature) {
                                    $html .= '
                <tr>
                    <td class="px-4 py-2 text-white">' . ($index + 1) . '</td>
                    <td class="px-4 py-2">' . e($feature) . '</td>
                </tr>
            ';
                                }

                                $html .= '
                        </tbody>
                    </table>
                </div>
            </div>
        ';

                                return new \Illuminate\Support\HtmlString($html);
                            }),




                    ]),
            ]);
    }

}