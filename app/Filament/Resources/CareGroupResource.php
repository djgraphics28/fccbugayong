<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareGroupResource\Pages;
use App\Filament\Resources\CareGroupResource\RelationManagers;
use App\Models\CareGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CareGroupResource extends Resource
{
    protected static ?string $model = CareGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('leader_id')
                    ->label('Leader')
                    ->relationship('leader', 'leader_id')
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                        <img src='" . ($record->getFirstMediaUrl('avatar') ?: ($record->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$record->first_name} {$record->last_name}" . ($record->ext_name ? " {$record->ext_name}" : "") . "</span>
                        </div>")
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->allowHtml(),
                Forms\Components\Select::make('mentor_id')
                    ->label('Mentor')
                    ->relationship('mentor', 'mentor_id')
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                         <img src='" . ($record->getFirstMediaUrl('avatar') ?: ($record->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$record->first_name} {$record->last_name}" . ($record->ext_name ? " {$record->ext_name}" : "") . "</span>
                        </div>")
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->allowHtml(),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_started'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mentor.full_name')
                    ->label('Mentor')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->mentor?->getFirstMediaUrl('avatar', 'public') ?: ($record->mentor?->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$state}</span>
                        </div>"
                    )
                    ->html(),
                Tables\Columns\TextColumn::make('leader.full_name')
                    ->label('Leader')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->leader?->getFirstMediaUrl('avatar', 'public') ?: ($record->leader?->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$state}</span>
                        </div>"
                    )
                    ->html(),
                Tables\Columns\TextColumn::make('members_count')
                    ->label('Total Members')
                    ->counts('members')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_started')
                    ->date()
                    ->sortable(),
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
                //
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
            RelationManagers\MembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareGroups::route('/'),
            'create' => Pages\CreateCareGroup::route('/create'),
            'edit' => Pages\EditCareGroup::route('/{record}/edit'),
        ];
    }
}
