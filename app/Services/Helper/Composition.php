<?php

namespace App\Services\Helper;

class Composition
{
    private $result;

    public function __construct($initial = [])
    {
        $this->result = \collect($initial);
    }

    public function withPrice(?array $price): self
    {
        if (!$price) {
            return $this;
        }

        $this->result = $this->result->put('price', $price);
        return $this;
    }

    public function withStock(?array $stock): self
    {
        if (!$stock) {
            return $this;
        }

        $this->result = $this->result->put('stock', $stock);
        return $this;
    }

    public function withQuoteShipping(?array $quoteShipping): self
    {
        if (!$quoteShipping) {
            return $this;
        }

        $this->result = $this->result->put('quoteShipping', $quoteShipping);
        return $this;
    }

    public function get(): array
    {
        return $this->result->all();
    }
}
