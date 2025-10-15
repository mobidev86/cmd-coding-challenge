<?php

use App\Enums\ServiceType;
use App\Livewire\QuoteRequestForm;
use App\Mail\NewQuoteStaff;
use App\Mail\QuoteReceivedCustomer;
use App\Models\Quote;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('quote request form renders successfully', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Request a Quote');
});

test('quote request form validates required fields', function () {
    Livewire::test(QuoteRequestForm::class)
        ->call('submit')
        ->assertHasErrors([
            'data.name' => 'required',
            'data.email' => 'required',
            'data.phone' => 'required',
            'data.address' => 'required',
            'data.service_type' => 'required',
            'data.booking_datetime' => 'required',
            'data.duration' => 'required',
        ]);
});

test('quote request form validates email format', function () {
    Livewire::test(QuoteRequestForm::class)
        ->fillForm([
            'email' => 'invalid-email',
        ])
        ->call('submit')
        ->assertHasErrors(['data.email']);
});

test('quote request form creates quote successfully', function () {
    Mail::fake();

    $formData = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'phone' => '9876543210',
        'address' => '456 Oak Avenue, City, State 12345',
        'service_type' => ServiceType::MAINTENANCE->value,
        'booking_datetime' => now()->addDays(5)->format('Y-m-d H:i:s'),
        'duration' => 3,
        'additional_notes' => 'Please call before arriving',
    ];

    $component = Livewire::test(QuoteRequestForm::class)
        ->set('data', $formData)
        ->call('submit');

    $this->assertDatabaseHas('quotes', [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'service_type' => ServiceType::MAINTENANCE->value,
    ]);
});

test('quote request form sends emails on submission', function () {
    Mail::fake();

    $formData = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'phone' => '9876543210',
        'address' => '456 Oak Avenue',
        'service_type' => ServiceType::CLEANING->value,
        'booking_datetime' => now()->addDays(5)->format('Y-m-d H:i:s'),
        'duration' => 2,
    ];

    Livewire::test(QuoteRequestForm::class)
        ->set('data', $formData)
        ->call('submit');

    Mail::assertSent(QuoteReceivedCustomer::class, function ($mail) {
        return $mail->hasTo('jane@example.com');
    });

    Mail::assertSent(NewQuoteStaff::class, function ($mail) {
        return $mail->hasTo(config('mail.from.address'));
    });
});

test('quote request form resets after successful submission', function () {
    Mail::fake();

    $formData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'address' => '123 Test St',
        'service_type' => ServiceType::CLEANING->value,
        'booking_datetime' => now()->addDays(3)->format('Y-m-d H:i:s'),
        'duration' => 1,
    ];

    $component = Livewire::test(QuoteRequestForm::class)
        ->set('data', $formData)
        ->call('submit');

    // Check that the form data is reset (should be empty or default values)
    $data = $component->get('data');
    expect($data['name'] ?? '')->toBe('');
    expect($data['email'] ?? '')->toBe('');
});
