<?php

use App\Entity\Vaisseaux;
use PHPUnit\Framework\TestCase;

class VaisseauxTest extends TestCase
{
    /* Vaisseau de base */

    public function testVaisseauOperationnel() {
        $vaisseau = new Vaisseaux(0, "Millenium", 100, true);
        $this->assertTrue($vaisseau->estOperationnel());
        $vaisseau->setEtat(false);
        $this->assertFalse($vaisseau->estOperationnel());
    }

    /* Vaisseau transport */

    public function testVaisseauCharge() {
        $vaisseau = new VaisseauxTransport(0, "Millenium", 0, true, 30);
        $vaisseau->charger(20);
        $this->assertEquals(20, $vaisseau->getChargeActuelle());
        $vaisseau->decharger(20);
        $this->assertEquals(0, $vaisseau->getChargeActuelle());
    }

    /* Vaisseau combat */

    public function testConsommationMunitions() {
        $vaisseau = new VaisseauxCombat(0, "Millenium", 0, true, 100);
        $vaisseau->tirer(100);
        $this->assertEquals(0, $vaisseau->getMunitions());
    }

    /* Utilisation de Data Provider */

    public function vaisseauProvider() {
        return [
            [100,0],
            [-10,0],
            [200,100],
        ];
    }

    // #[@dataProvider('vaisseauProvider')]
    public function testVaisseauChargeDataProvider($charge, $expected) {
        $vaisseau = new VaisseauxTransport(0, "Millenium", 0, true, 30);
        $vaisseau->charger($charge);
        $this->assertEquals($expected, $vaisseau->getChargeActuelle());
    }
}