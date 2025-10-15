<?php

use App\Enums\QuoteStatus;
use App\Enums\ServiceType;
use App\Models\Quote;

test('quote calculates estimated price correctly on creation', function () {
    $quote = Quote::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'address' => '123 Main St',
        'service_type' => ServiceType::CLEANING,
        'booking_datetime' => now()->addDays(7),
        'duration' => 2,
    ]);

    expect($quote->estimated_price)->toBe('80.00'); // $40/hr * 2 hours
});

test('quote uses correct hourly rate for each service type', function () {
    $cleaningQuote = Quote::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'address' => '123 Test St',
        'service_type' => ServiceType::CLEANING,
        'booking_datetime' => now()->addDays(1),
        'duration' => 1,
    ]);

    $maintenanceQuote = Quote::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'address' => '123 Test St',
        'service_type' => ServiceType::MAINTENANCE,
        'booking_datetime' => now()->addDays(1),
        'duration' => 1,
    ]);

    $inspectionsQuote = Quote::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'address' => '123 Test St',
        'service_type' => ServiceType::INSPECTIONS,
        'booking_datetime' => now()->addDays(1),
        'duration' => 1,
    ]);

    expect($cleaningQuote->estimated_price)->toBe('40.00');
    expect($maintenanceQuote->estimated_price)->toBe('50.00');
    expect($inspectionsQuote->estimated_price)->toBe('70.00');
});

test('quote starts with pending status by default', function () {
    $quote = Quote::factory()->create();

    expect($quote->status)->toBe(QuoteStatus::PENDING);
});

test('getPriceToDisplay returns final price when set', function () {
    $quote = Quote::factory()->create([
        'estimated_price' => 100.00,
        'final_price' => 120.00,
    ]);

    expect($quote->getPriceToDisplay())->toBe(120.00);
});

test('getPriceToDisplay returns estimated price when final price is null', function () {
    $quote = Quote::factory()->create([
        'estimated_price' => 100.00,
        'final_price' => null,
    ]);

    expect($quote->getPriceToDisplay())->toBe(100.00);
});

test('quote can be approved with final price', function () {
    $quote = Quote::factory()->create([
        'status' => QuoteStatus::PENDING,
    ]);

    $quote->update([
        'status' => QuoteStatus::APPROVED,
        'final_price' => 150.00,
    ]);

    expect($quote->status)->toBe(QuoteStatus::APPROVED);
    expect($quote->final_price)->toBe('150.00');
});

test('quote can be rejected with reason', function () {
    $quote = Quote::factory()->create([
        'status' => QuoteStatus::PENDING,
    ]);

    $quote->update([
        'status' => QuoteStatus::REJECTED,
        'rejection_reason' => 'Service unavailable in your area',
    ]);

    expect($quote->status)->toBe(QuoteStatus::REJECTED);
    expect($quote->rejection_reason)->toBe('Service unavailable in your area');
});

test('quote can progress through status workflow', function () {
    $quote = Quote::factory()->create([
        'status' => QuoteStatus::PENDING,
    ]);

    $quote->update(['status' => QuoteStatus::APPROVED, 'final_price' => 100]);
    expect($quote->fresh()->status)->toBe(QuoteStatus::APPROVED);

    $quote->update(['status' => QuoteStatus::SCHEDULED]);
    expect($quote->fresh()->status)->toBe(QuoteStatus::SCHEDULED);

    $quote->update(['status' => QuoteStatus::INVOICED]);
    expect($quote->fresh()->status)->toBe(QuoteStatus::INVOICED);
});

test('booking datetime is stored in UTC', function () {
    $localTime = now()->setTimezone('America/New_York');

    $quote = Quote::factory()->create([
        'booking_datetime' => $localTime,
    ]);

    expect($quote->booking_datetime->timezone->getName())->toBe('UTC');
});
