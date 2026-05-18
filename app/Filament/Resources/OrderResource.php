<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model          = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int    $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Customer Information')->schema([
                Forms\Components\TextInput::make('customer_name')->disabled(),
                Forms\Components\TextInput::make('phone')->disabled(),
                Forms\Components\TextInput::make('email')->disabled(),
                Forms\Components\Textarea::make('address')->disabled()->columnSpanFull(),
                Forms\Components\Textarea::make('notes')->disabled()->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Order Status')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'paid'       => 'Paid',
                        'processing' => 'Processing',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ])
                    ->required(),

                Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid'   => 'Paid',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('total_amount')
                    ->prefix('₦')
                    ->disabled(),

                Forms\Components\TextInput::make('payment_reference')->disabled(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('Order #')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->money('NGN')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => ['paid', 'delivered'],
                        'info'    => 'processing',
                        'danger'  => 'cancelled',
                    ]),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'danger'  => 'unpaid',
                        'success' => 'paid',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'paid'       => 'Paid',
                        'processing' => 'Processing',
                        'delivered'  => 'Delivered',
                        'cancelled'  => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options(['unpaid' => 'Unpaid', 'paid' => 'Paid']),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrders::route('/'),
            'view'   => Pages\ViewOrder::route('/{record}'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
