<?php

class SymbolTable
{

    protected $symbols = array();

    protected $next_variable = 16;

    public function __construct()
    {
        $this->symbols = array(
            'SP' => 0,
            'LCL' => 1,
            'ARG' => 2,
            'THIS' => 3,
            'THAT' => 4,

            'SCREEN' => 16384,
            'KBD' => 2457
        );

        // R0-R15
        // 0-15 0x0000-f
        for ($i=0; $i<16; $i++) {
            $this->symbols['R' . $i] = $i;
        }

    }

    /**
     * Adds the pair to the table, generates an address if needed.
     */
    public function addEntry($symbol, $address = false)
    {
        // Create the address.
        if ($address === false) {
            $address = $this->next_variable;
            $this->next_variable++;
        }

        $this->symbols[$symbol] = $address;

        return $address;
    }

    /**
     * Does the symbol table contain the given symbol?
     */
    public function contains($symbol)
    {
        if (isset($this->symbols[$symbol])) {
            return true;
        }

        return false;
    }

    /**
     * Returns the address associated with the symbol.
     */
    public function getAddress($symbol)
    {
        if (isset($this->symbols[$symbol])) {
            return $this->symbols[$symbol];
        }

        return null;
    }
}
