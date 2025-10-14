<?php

namespace App\Jobs;

use App\Models\Registration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMessageJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(Registration $registration)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registration = Registration::find($this->registration->id);


        if (! $registration) {

            return;

        }


        try {

            $response = Http::post('https://webhook.sellflux.app/v2/webhook/custom/4d454b4a9d52da3a11d6837a79028b60',
            [
                'name' => $registration->first_name,
                'phone' => '+55' . preg_replace('/\D/', '', $registration->mobile_phone),
                'email' => $registration->email,
            ]);

            Log::info("Message sent successfully for registration ID $registration->id ", [
                'status' => $response->status(),
                'response' => $response->body()
            ]);


        } catch (\Exception $e) {

            // Log de erro ou outra ação apropriada
            Log::error('Failed to send message for registration ID ' . $registration->id . ': ' . $e->getMessage());

        }

    }
}
