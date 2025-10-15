<?php

namespace App\Livewire;

use App\Enums\ServiceType;
use App\Mail\NewQuoteStaff;
use App\Mail\QuoteReceivedCustomer;
use App\Models\Quote;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class QuoteRequestForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Contact Information')
                    ->description('Please provide your contact details so we can reach you')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter your full name (e.g., John Smith)')
                            ->live(onBlur: true)
                            ->autocomplete('name')
                            ->columnSpan(1),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('your.email@example.com')
                            ->live(onBlur: true)
                            ->autocomplete('email')
                            ->columnSpan(1),

                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('(555) 123-4567')
                            ->mask('(999) 999-9999')
                            ->live(onBlur: true)
                            ->autocomplete('tel')
                            ->columnSpanFull(),

                        Textarea::make('address')
                            ->label('Service Address')
                            ->required()
                            ->rows(3)
                            ->placeholder('Enter the complete address where you need the service (e.g., 123 Main Street, Apt 4B, New York, NY 10001)')
                            ->autocomplete('street-address')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->collapsible()
                    ->persistCollapsed(false)
                    ->compact(),

                Section::make('Service Details')
                    ->description('Tell us about the service you need and when you need it')
                    ->schema([
                        Select::make('service_type')
                            ->label('Service Type')
                            ->options(ServiceType::toSelectArray())
                            ->required()
                            ->placeholder('Choose the type of service you need')
                            ->helperText('💡 Not sure? Contact us for a consultation')
                            ->columnSpan(1),

                        DateTimePicker::make('booking_datetime')
                            ->label('Preferred Date & Time')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->displayFormat('M d, Y - h:i')
                            ->placeholder('When would you like the service?')
                            ->helperText('📅 We\'ll confirm availability within 24 hours')
                            ->columnSpan(1),

                        TextInput::make('duration')
                            ->label('Estimated Duration')
                            ->required()
                            ->numeric()
                            ->minValue(0.5)
                            ->maxValue(24)
                            ->step(0.5)
                            ->suffix('hours')
                            ->placeholder('e.g., 2.5')
                            ->helperText('⏱️ Don\'t worry if you\'re not sure - we\'ll provide an accurate estimate')
                            ->columnSpanFull(),

                        Textarea::make('additional_notes')
                            ->label('Additional Notes & Special Requirements')
                            ->rows(4)
                            ->placeholder('Tell us more about your project! Include any special requirements, access instructions, preferred materials, or anything else that would help us provide the best service...')
                            ->helperText('💬 The more details you provide, the more accurate your quote will be')
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 1,
                        'sm' => 1,
                        'md' => 2,
                    ])
                    ->collapsible()
                    ->persistCollapsed(false)
                    ->compact(),
            ])
            ->statePath('data');

    }

    public function submit(): void
    {


        $data = $this->form->getState();

        $quote = Quote::create($data);

        Mail::to($quote->email)->send(new QuoteReceivedCustomer($quote));
        Mail::to(config('mail.from.address'))->send(new NewQuoteStaff($quote));



        Notification::make()
            ->success()
            ->title('Quote request submitted!')
            ->body('Thank you! We\'ve received your request and will contact you soon.')
            ->duration(5000)
            ->send();

        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.quote-request-form');
    }
}
