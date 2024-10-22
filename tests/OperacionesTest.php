<?php

use PHPUnit\Framework\TestCase;

class OperacionesTest extends TestCase {

    private $op;

    public function setUp():void {
        $this->op = new Operaciones();
    }

    public function testSuma() {
        $this->assertEquals(4, $this->op->sumar(2, 2));
    }

    public function testSumaNulos() {
        // $this->assertEquals(NULL, $this->op->sumar(NULL, NULL));
        $this->op->sumar(NULL, NULL);
    }

    public function testSumaLetras() {
        // $this->assertEquals(NULL, $this->op->sumar(NULL, NULL));
        $this->op->sumar('a', 'b');
    }

    public function testSumaValores() {
        // $this->assertEquals(NULL, $this->op->sumar(NULL, NULL));
        $this->op->sumar(2, 'a');
    }
}
