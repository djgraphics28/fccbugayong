<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Family;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FamilyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FamilyResource\RelationManagers;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('family_name')
                    ->label('Family Name')
                    ->columnSpanFull()
                    ->placeholder('Dela Cruz Family')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('first_name')
                    ->label('Father')
                    ->relationship('fatherData', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->getFirstMediaUrl('profile_picture') ?: asset('images/male.png')) . "' 
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$record->first_name} {$record->last_name}" . ($record->ext_name ? " {$record->ext_name}" : "") . "</span>
                        </div>")
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->allowHtml(),
                Forms\Components\Select::make('mother')
                    ->label('Mother')
                    ->relationship('motherData', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->getFirstMediaUrl('profile_picture') ?: asset('images/female.png')) . "' 
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
                Tables\Columns\TextColumn::make('family_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fatherData.full_name')
                    ->label('Father')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->fatherData?->getFirstMediaUrl('profile_picture') ?: asset('images/male.png')) . "' 
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$state}</span>
                        </div>"
                    )
                    ->html(),
                Tables\Columns\TextColumn::make('motherData.full_name')
                    ->label('Mother')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->motherData?->getFirstMediaUrl('profile_picture') ?: asset('images/female.png')) . "' 
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('print')
                        ->label('Print Selected')
                        ->icon('heroicon-o-printer')
                        ->action(function (Collection $records) {
                            $ids = $records->pluck('id')->toArray();
                            return redirect()->route('print.families', [
                                'ids' => implode(',', $ids)
                            ]);
                        })
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
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}
