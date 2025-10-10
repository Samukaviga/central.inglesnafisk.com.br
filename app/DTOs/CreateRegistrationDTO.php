<?php

namespace App\DTOs;

use Carbon\Carbon;

class CreateRegistrationDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $email,
        public readonly string $mobile_phone,
        public readonly ?string $date_of_birth,
        public readonly ?string $phone,
        public readonly ?string $age,
        public readonly ?string $gender,
        public readonly ?string $course,
        public readonly ?string $status,

        public readonly string $lead_source,
        public readonly ?string $utm_source = null,
        public readonly ?string $utm_medium = null,
        public readonly ?string $utm_campaign = null,
        public readonly ?string $utm_term = null,
        public readonly ?string $utm_content = null,
        public readonly ?string $gclid = null,
        public readonly ?string $fbclid = null,
        public readonly ?string $msclkid = null,
        public readonly ?string $referrer = null,
        public readonly ?string $landing_page = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $required = ['name', 'mobile_phone'];

        foreach ($required as $field) {
            if (!array_key_exists($field, $data)) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        $dob = self::toYmdDate((string) ($data['date_of_birth'] ?? ''));

        return new self(
            name: trim((string) $data['name']),
            mobile_phone: self::cleanPhoneMask((string) $data['mobile_phone']),
            phone: trim((string) ($data['phone'] ?? '')),
            email: self::nullIfEmpty(strtolower(trim((string) ($data['email'] ?? '')))),
            date_of_birth: $dob === '' ? null : $dob,
            age: $dob == '' ? null : Carbon::parse($dob)->age,
            gender: self::nullIfEmpty($data['gender'] ?? null),
            course: self::nullIfEmpty($data['course'] ?? null),
            status: self::nullIfEmpty($data['status'] ?? null),

            lead_source: trim((string) ($data['lead_source'] ?? '')),

            utm_source: self::nullIfEmpty($data['utm_source'] ?? null),
            utm_medium: self::nullIfEmpty($data['utm_medium'] ?? null),
            utm_campaign: self::nullIfEmpty($data['utm_campaign'] ?? null),
            utm_term: self::nullIfEmpty($data['utm_term'] ?? null),
            utm_content: self::nullIfEmpty($data['utm_content'] ?? null),
            gclid: self::nullIfEmpty($data['gclid'] ?? null),
            fbclid: self::nullIfEmpty($data['fbclid'] ?? null),
            msclkid: self::nullIfEmpty($data['msclkid'] ?? null),
            referrer: self::nullIfEmpty($data['referrer'] ?? null),
            landing_page: self::nullIfEmpty($data['landing_page'] ?? null),
        );
    }

    private static function nullIfEmpty(?string $v): ?string
    {
        if ($v === null) return null;
        $t = trim($v);
        return $t === '' ? null : $t;
    }

    private static function toYmdDate(string $date): string
    {
        $date = trim($date);
        if ($date === '') return '';

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            [$d, $m, $y] = explode('/', $date);
            return sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        }
        return $date;
    }

    private static function cleanPhoneMask(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone);
    }

    public function toArray(): array
    {
        $base = [
            'name'         => $this->name,
            'email'        => $this->email,
            'mobile_phone' => $this->mobile_phone,
            'phone'        => $this->phone,
            'date_of_birth'=> $this->date_of_birth,
            'age'          => $this->age,
            'gender'       => $this->gender,
            'course'       => $this->course,
            'status'       => $this->status,
            'lead_source'  => $this->lead_source,
            'utm_source'   => $this->utm_source,
            'utm_medium'   => $this->utm_medium,
            'utm_campaign' => $this->utm_campaign,
            'utm_term'     => $this->utm_term,
            'utm_content'  => $this->utm_content,
            'gclid'        => $this->gclid,
            'fbclid'       => $this->fbclid,
            'msclkid'      => $this->msclkid,
            'referrer'     => $this->referrer,
            'landing_page' => $this->landing_page,
        ];

        return array_filter($base, static fn($v) => !is_null($v));
    }
}
