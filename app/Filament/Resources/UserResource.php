<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'User Management';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),

                        Select::make('role')
                            ->options([
                                'user' => 'User',
                                'seller' => 'Seller',
                                'admin' => 'Admin',
                            ])
                            ->required()
                            ->default('user'),

                        TextInput::make('password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => bcrypt($state)),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->searchable(),

                BadgeColumn::make('role')
                    ->colors([
                        'primary' => 'user',
                        'success' => 'seller',
                        'danger' => 'admin',
                    ])
                    ->sortable(),

                TextColumn::make('seller.store_name')
                    ->label('Store Name')
                    ->searchable()
                    ->placeholder('N/A'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(
                        fn(User $record) =>
                        $record->role === 'seller'
                        ? $record->seller?->is_suspended
                        : $record->is_suspended
                    )
                    ->formatStateUsing(fn($state) => $state ? 'Suspended' : 'Active')
                    ->colors([
                        'success' => false,
                        'danger' => true,
                    ])
                    ->placeholder('N/A'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'seller' => 'Seller',
                        'admin' => 'Admin',
                    ]),


                SelectFilter::make('seller_suspended')
                    ->label('Seller Status')
                    ->options([
                        '0' => 'Active',
                        '1' => 'Suspended',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value): Builder => $query->whereHas('seller', function ($q) use ($value) {
                                $q->where('is_suspended', $value === '1');
                            })
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Action::make('suspend_user')
                    ->label('Suspend User')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(User $record) => $record->role === 'user' && !$record->is_suspended)
                    ->action(fn(User $record) => $record->update(['is_suspended' => true]))
                    ->after(fn() => Notification::make()->title('User suspended')->success()->send()),

                Action::make('unsuspend_user')
                    ->label('Unsuspend User')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(User $record) => $record->role === 'user' && $record->is_suspended)
                    ->action(fn(User $record) => $record->update(['is_suspended' => false]))
                    ->after(fn() => Notification::make()->title('User unsuspended')->success()->send()),

                Action::make('suspend_seller')
                    ->label('Suspend Seller')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(User $record) => $record->role === 'seller' && $record->seller && !$record->seller->is_suspended)
                    ->action(fn(User $record) => $record->seller->update(['is_suspended' => true]))
                    ->after(fn() => Notification::make()->title('Seller suspended successfully')->success()->send()),

                Action::make('unsuspend_seller')
                    ->label('Unsuspend Seller')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(User $record) => $record->role === 'seller' && $record->seller && $record->seller->is_suspended)
                    ->action(fn(User $record) => $record->seller->update(['is_suspended' => false]))
                    ->after(fn() => Notification::make()->title('Seller unsuspended successfully')->success()->send()),


                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}