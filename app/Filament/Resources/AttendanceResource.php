<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Member;
use Filament\Forms\Form;
use App\Models\Attendance;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use Filament\Tables\Actions\Action;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->label('Member')
                    ->options(Member::query()->pluck('first_name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('service_date')
                    ->label('Date')
                    ->default(now())
                    ->required(),
                Forms\Components\DatePicker::make('time_in')
                    ->label('Time In')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.full_name')->label('Member Name'),
                Tables\Columns\TextColumn::make('service_date')->label('Date'),
            ])
            ->filters([
                Tables\Filters\Filter::make('sundays')
                    ->label('Only Sundays')
                    ->query(fn(Builder $query) => $query->whereDayOfWeek('date', 0)), // Sunday is 0
            ])
            ->actions([
                Action::make('createAttendance')
                    ->label('Mark Attendance')
                    ->modalHeading('Mark Attendance for Members')
                    ->form([
                        Forms\Components\Repeater::make('member')
                            ->label('Select Members')
                            ->relationship('member')
                            ->schema([
                                Forms\Components\CheckboxList::make('member')
                                    ->label('Members')
                                    ->options(
                                        Member::query()
                                            ->whereDoesntHave('attendances', fn($query) => $query->where('service_date', today()))
                                            ->pluck('first_name', 'id')
                                    ),
                            ]),
                    ])
                    ->action(function (array $data): void {
                        foreach ($data['members'] as $memberId) {
                            Attendance::create([
                                'member_id' => $memberId,
                                'service_date' => now(),
                            ]);
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
