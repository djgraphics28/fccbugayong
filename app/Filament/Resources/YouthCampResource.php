<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\YouthCamp;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\YouthCampResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class YouthCampResource extends Resource
{
    protected static ?string $model = YouthCamp::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Registrations';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('middle_name')->maxLength(255),
                Forms\Components\TextInput::make('last_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('suffix')->maxLength(255),
                Forms\Components\TextInput::make('gender')->required(),
                Forms\Components\TextInput::make('nickname')->maxLength(255),
                Forms\Components\TextInput::make('contact_number')->maxLength(255),
                Forms\Components\DatePicker::make('birthday')->required(),
                Forms\Components\Select::make('event')
                    ->options([
                        'lcr' => 'LCR',
                        'youth-camp' => 'Youth Camp',
                    ])
                    ->default('youth-camp')
                    ->required(),
                Forms\Components\TextInput::make('church')->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->searchable(),
                Tables\Columns\TextColumn::make('suffix'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('nickname')->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('contact_number'),
                Tables\Columns\TextColumn::make('birthday')->date()->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Age')
                    ->getStateUsing(fn($record) => Carbon::parse($record->birthday)->age)
                    ->sortable(),
                Tables\Columns\TextColumn::make('event')->searchable(),
                Tables\Columns\TextColumn::make('church')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'lcr' => 'LCR',
                        'youth-camp' => 'Youth Camp',
                    ])
                    ->default('youth-camp'),
                SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female',
                    ]),
                SelectFilter::make('church')
                    ->label('Church')
                    ->options([
                        NULL => 'Visitors', // Special value for NULL filtering
                        'FCC Bugayong' => 'FCC Bugayong',
                        'FCC San Bonifacio' => 'FCC San Bonifacio',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouthCamps::route('/'),
            'create' => Pages\CreateYouthCamp::route('/create'),
            'edit' => Pages\EditYouthCamp::route('/{record}/edit'),
        ];
    }
}
