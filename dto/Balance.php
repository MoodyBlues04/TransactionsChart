<?php

namespace app\dto;

class Balance
{
    private array $data = [];

    public function add(string $time, float|int $profit)
    {
        $this->data[] = [
            'time' => $time,
            'balance' => $this->getLastBalance() + $profit
        ];
    }

    public function getAll(): array
    {
        return $this->data;
    }

    public function getTime(): array
    {
        return array_map(fn ($item) => $item['time'], $this->data);
    }

    public function getBalance(): array
    {
        return array_map(fn ($item) => $item['balance'], $this->data);
    }

    private function getLastBalance(): int
    {
        return !empty($this->data) ? end($this->data)['balance'] : 0;
    }
}
