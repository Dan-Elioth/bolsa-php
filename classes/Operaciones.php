<?php

class Operaciones{
    public function sumar($n1, $n2) {
        if ($n1 == NULL || $n2 == NULL) throw new InvalidArgumentException('Los valores no pueden ser nulos');

        if (is_string($n1) && is_string($n2)) throw new InvalidArgumentException('Los valores no pueden ser letras');

        if (is_numeric($n1) && is_string($n2)) throw new InvalidArgumentException('Los dos valores deben ser numéricos');
        if (is_string($n1) && is_numeric($n2)) throw new InvalidArgumentException('Los dos valores deben ser numéricos');

        return $n1 + $n2;
    }
}

