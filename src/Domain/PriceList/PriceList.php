<?php
declare(strict_types=1);

namespace Clovnrian\MoneyBridge\Domain\PriceList;

final class PriceList
{
    /** @var string */
    private $id;

    /** @var string */
    private $code;

    /** @var string */
    private $name;

    /** @var \DateTimeInterface */
    private $validFrom;

    /** @var \DateTimeInterface */
    private $validTo;

    public static function fromMoney(array $data): self
    {
        return new self(
            $data['Cenik_ID'],
            $data['Kod'],
            $data['Nazev'],
            new \DateTime($data['PlatnostOd']),
            new \DateTime($data['PlatnostDo'])
        );
    }

    private function __construct(
        string $id,
        string $code,
        string $name,
        \DateTimeInterface $validFrom,
        \DateTimeInterface $validTo
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->validFrom = $validFrom;
        $this->validTo = $validTo;
    }
}
