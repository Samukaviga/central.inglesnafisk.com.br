<?php


it('creates a registration via API', function () {
   

    $payload = [
        "student_name" => "Samuel",
        "responsible_name" => "Clemencia Marlene",
        "indicated_student_name" => "Rafael Gomes",
        "indicated_responsible_name" => "Maria Gomes",
        "indicated_mobile_phone" => "11965124506",
        "indicated_email" => "samuelgomes2021@gmail.com",
        "indicated_education_level" => "1° ano fundamental",
        "indicated_date_of_birth" => "18/12/2000",
        "lead_source" => "direct"
    ];

    $response = $this->withoutExceptionHandling()->postJson('/api/registrations', $payload);

    dd($response->json(), $response->status());

    $response->assertStatus(201)
             ->assertJsonStructure([
                 'success',
                 'data' => [
                     'id',
                     'student_name',
                     'responsible_name',
                     'indicated_student_name',
                     'indicated_responsible_name',
                     'indicated_mobile_phone',
                     'indicated_email',
                     'indicated_education_level',
                     'indicated_date_of_birth',
                     'lead_source',
                     'created_at',
                     'updated_at'
                 ]
             ]);

    // Verifica se o registro foi salvo no banco
    $this->assertDatabaseHas('registrations', [
        'student_name' => 'Samuel',
        'indicated_email' => 'samuelgomes2021@gmail.com'
    ]);
});
