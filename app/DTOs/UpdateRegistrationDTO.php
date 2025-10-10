<?php

namespace App\DTOs;

use Illuminate\Support\Str;

class UpdateRegistrationDTO
{
    public function __construct(
        public readonly ?string $indicated_education_level,
        public readonly ?string $indicated_date_of_birth,
    ) {}

    public static function fromArray(array $data): self
    {
        /*
        $required = [
            'student_name',
            'responsible_name',
            'indicated_student_name',
            'indicated_responsible_name',
            'indicated_mobile_phone',
        ];

        foreach ($required as $field) {
            if (!array_key_exists($field, $data)) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        } */

        $dob = self::toYmdDate((string) $data['indicated_date_of_birth']);


        return new self(
            indicated_date_of_birth: $dob,
            indicated_education_level: trim((string) $data['indicated_education_level']),
        );
    }

    private static function nullIfEmpty(?string $v): ?string
    {
        if ($v === null) return null;
        $t = trim($v);
        return $t === '' ? null : $t;
    }

    /**
     * Converte "dd/mm/yyyy" em "Y-m-d". Se já vier "Y-m-d", mantém.
     */
    private static function toYmdDate(string $date): string
    {
        $date = trim($date);
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            [$d, $m, $y] = explode('/', $date);
            return sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        }
        return $date;
    }

    public function toArray(): array
    {
        $base = [
            'indicated_date_of_birth'     => $this->indicated_date_of_birth,
            'indicated_education_level' => $this->indicated_education_level,                       
        ];

        return array_filter($base, static fn($v) => !is_null($v));
    }
}