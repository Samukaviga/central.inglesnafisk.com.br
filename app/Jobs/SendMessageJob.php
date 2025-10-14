<?php

namespace App\Jobs;

use App\Enums\RegistrationCity;
use App\Models\Registration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMessageJob implements ShouldQueue
{
    use Queueable;

    protected Registration $registration;

    /**
     * Create a new job instance.
     */
    public function __construct(Registration $registration)
    {
        // Armazena a instância no job (Laravel serializa automaticamente)
        $this->registration = $registration;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $registration = Registration::find($this->registration->id);

        if (! $registration) {
            Log::warning("Registration not found: ID {$this->registration->id}");
            return;
        }

        try {
            // compara com Enum (recomendado se city tiver cast)
            if ($registration->city === RegistrationCity::SUZANO) {
                $webhookUrl = 'https://webhook.sellflux.app/v2/webhook/custom/bc56928414aa893be6aea14c02f1c958';
            } elseif ($registration->city === RegistrationCity::ITAQUAQUECETUBA) {
                $webhookUrl = 'https://webhook.sellflux.app/v2/webhook/custom/8456b530b0d0b90264b472ec26ef1abb';
            } else {
                Log::info("No webhook configured for city: {$registration->city->value}");
                return;
            }

            $response = Http::post($webhookUrl, [
                'name'  => $registration->first_name,
                'phone' => '+55' . preg_replace('/\D/', '', $registration->mobile_phone),
                'email' => $registration->email,
            ]);

            Log::info("Message sent successfully for registration ID {$registration->id}", [
                'status'   => $response->status(),
                'response' => $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed to send message for registration ID {$registration->id}: {$e->getMessage()}");
        }
    }
}
