<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Member;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Table\Columns\ImageColumn;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MemberResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\MemberResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->image()
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                    ->collection('avatar')
                    ->preserveFilenames()
                    ->disk('public')
                    ->maxFiles(1),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ext_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nickname')
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female'
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\TextInput::make('contact_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_baptized'),
                Forms\Components\Toggle::make('is_first_time')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('is_approved')
                    ->required(),
                Forms\Components\Textarea::make('e_signature')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('position')
                    ->maxLength(255),
                Forms\Components\Toggle::make('vbs_added')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(
                        fn($record) =>
                        $record->getFirstMediaUrl('avatar')
                        ? $record->getFirstMediaUrl('avatar')
                        : ($record->gender === 'Male'
                            ? asset('images/male.png')
                            : asset('images/female.png'))
                    ),
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ext_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nickname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Birth Date')
                    ->date('F d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('age')
                    ->label('Age')
                    ->getStateUsing(fn($record): int => Carbon::parse($record->birth_date)->age)
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query->orderByRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) ' . $direction);
                    }),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_baptized')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_first_time')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('vbs_added')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->options([
                        'Male' => 'Male',
                        'Female' => 'Female'
                    ]),
                Tables\Filters\SelectFilter::make('age')
                    ->options([
                        '0-12' => '0-12',
                        '13-19' => '13-19',
                        '20-29' => '20-29',
                        '30-39' => '30-39',
                        '40-49' => '40-49',
                        '50+' => '50+'
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $today = now();
                        return match ($data['value']) {
                            '0-12' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) <= 12'),
                            '13-19' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 13 AND 19'),
                            '20-29' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 20 AND 29'),
                            '30-39' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 30 AND 39'),
                            '40-49' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 40 AND 49'),
                            '50+' => $query->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) >= 50'),
                            default => $query
                        };
                    }),
                Tables\Filters\SelectFilter::make('birth_month')
                    ->label('Birthday Month')
                    ->options([
                        '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'August',
                        '9' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December'
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $data['value']
                            ? $query->whereRaw('MONTH(birth_date) = ?', [$data['value']])
                            : $query;
                    }),
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Active Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive'
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
