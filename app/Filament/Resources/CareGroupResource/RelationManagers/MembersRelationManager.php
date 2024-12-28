<?php

namespace App\Filament\Resources\CareGroupResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;

class MembersRelationManager extends RelationManager
{
    protected static string $relationship = 'members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->label('Select Member')
                    ->relationship('member', 'member_id') // Ensure 'id' matches the primary key in the `users` table
                    ->searchable(['first_name', 'last_name'])
                    ->getOptionLabelFromRecordUsing(fn($record) =>
                        "<div class='flex items-center gap-2'>
                            <img src='" . ($record->getFirstMediaUrl('avatar') ?: asset('images/male.png')) . "'
                            class='w-8 h-8 rounded-full object-cover'/>
                            <span>{$record->first_name} {$record->last_name}" . ($record->ext_name ? " {$record->ext_name}" : "") . "</span>
                        </div>")
                    ->preload()
                    ->allowHtml()
                    ->required() // Ensure the field is required
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('member.full_name')
                    ->label('Member Name')
                    ->sortable()
                    ->formatStateUsing(
                        fn($record, $state) =>
                        "<div class='flex items-center gap-2'>
                        <img src='" . ($record->member?->getFirstMediaUrl('profile_picture') ?: ($record->member?->gender === 'Female' ? asset('images/female.png') : asset('images/male.png'))) . "'
                        class='w-8 h-8 rounded-full object-cover'/>
                        <span>{$state}</span>
                    </div>"
                    )
                    ->html(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->afterStateUpdated(function ($record) {
                        if ($record->is_active) {
                            Notification::make()
                                ->title('Member Activated')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Member Deactivated')
                                ->warning()
                                ->send();
                        }
                    }),
            ])
            ->filters([
                // Add any necessary filters
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
