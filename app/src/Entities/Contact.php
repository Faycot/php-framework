<?php

namespace App\Entities;

class Contact
{
    private string $email;
    private string $subject;
    private string $message;
    private int $dateOfCreation;
    private int $dateOfLastUpdate;

    public function __construct(
        string $email,
        string $subject,
        string $message,
        int $dateOfCreation,
        int $dateOfLastUpdate
    ) {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->dateOfCreation = $dateOfCreation;
        $this->dateOfLastUpdate = $dateOfLastUpdate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getDateOfCreation(): int
    {
        return $this->dateOfCreation;
    }

    public function getDateOfLastUpdate(): int
    {
        return $this->dateOfLastUpdate;
    }

    public function toArray(): array
    {
        return [
            "email"            => $this->email,
            "subject"          => $this->subject,
            "message"          => $this->message,
            "dateOfCreation"   => $this->dateOfCreation,
            "dateOfLastUpdate" => $this->dateOfLastUpdate,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data["email"],
            $data["subject"],
            $data["message"],
            $data["dateOfCreation"],
            $data["dateOfLastUpdate"]
        );
    }

    public static function loadAll(): array
    {
        $directory = __DIR__ . "/../../var/contacts/";
        $files = glob($directory . "*.json");

        $contacts = [];

        foreach ($files as $file) {
            $json = json_decode(file_get_contents($file), true);
            if ($json) {
                $contact = Contact::fromArray($json);
                $contacts[] = $contact->toArray();
            }
        }

        return $contacts;
    }
}
