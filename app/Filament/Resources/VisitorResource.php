<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Visitor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VisitorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VisitorResource\RelationManagers;

class VisitorResource extends Resource
{
    protected static ?string $model = Visitor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Forms\Components\DatePicker::make('birth_date'),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('contact_number')
                    ->maxLength(255),
                Forms\Components\Select::make('invited_by')
                    ->label('Invited By')
                    ->relationship('member', 'invited_by')
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->getFirstMediaUrl('avatar') ?: ($record->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$record->first_name} {$record->last_name}" . ($record->ext_name ? " {$record->ext_name}" : "") . "</span>
                        </div>")
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->allowHtml(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('ext_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('member.full_name')
                //     ->label('Invited By')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('member.full_name')
                    ->label('Invited By')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->member?->getFirstMediaUrl('avatar') ?: ($record->member?->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$state}</span>
                        </div>"
                    )
                    ->html(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('invited_by')
                    ->relationship('member', 'first_name')
                    ->getOptionLabelFromRecordUsing(
                        fn($record) =>
                        "{$record->first_name} {$record->last_name}" .
                        ($record->ext_name ? " {$record->ext_name}" : "")
                    )
                    ->searchable()
                    ->preload()
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListVisitors::route('/'),
            'create' => Pages\CreateVisitor::route('/create'),
            'edit' => Pages\EditVisitor::route('/{record}/edit'),
        ];
    }
}
