<?php

namespace App\Actions;

use App\DTOs\CreateRegistrationDTO;
use App\Models\Registration;

class CreateRegistrationAction
{
    public function execute(CreateRegistrationDTO $dto): Registration
    {
        return Registration::create($dto->toArray());
    }
}