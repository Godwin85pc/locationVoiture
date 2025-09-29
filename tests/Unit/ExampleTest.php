<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);

        /**effectuer le test d'une relation entre deux modèles
         * $vehicule = Vehicule::find(1);
         * $this->assertInstanceOf(Utilisateur::class, $vehicule->proprietaire);
         * 
         */

       
    }
}
