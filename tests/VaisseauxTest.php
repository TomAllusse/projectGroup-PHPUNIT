<?php

use PHPUnit\Framework\TestCase;
use App\Entities\Vaisseaux;
use App\Entities\VaisseauxTransport;
use App\Entities\VaisseauxCombat;
use PHPUnit\Framework\Attributes\DataProvider;

class VaisseauxTest extends TestCase
{
    /* Vaisseau de base */

    public function testVaisseauEtat() {
        $vaisseau = new Vaisseaux("Millenium", 100);
        $this->assertTrue($vaisseau->getEtat());
        $vaisseau->setEtat(false);
        $this->assertFalse($vaisseau->getEtat());
    }
    public function testConsommationEnergie(){
        $vaisseau = new Vaisseaux("Millenium", 100);
        $vaisseau->setCarburant(50);
        $vaisseau->interaction("consommationEnergie", 20);
        $this->assertEquals(30, $vaisseau->getCarburant());
    }
    public function testConsommationImpossible(){
        $vaisseau = new Vaisseaux("Millenium", 100);
        $vaisseau->setCarburant(10);
        $message = $vaisseau->interaction("consommationEnergie", 50);
        $this->assertStringContainsString("Pas assez de carburant", $message);
        $message = $vaisseau->interaction("consommationEnergie", -10);
        $this->assertStringContainsString("positive", $message);
        $message = $vaisseau->interaction("consommationEnergie");
        $this->assertStringContainsString("paramètre manquant", $message);
        $vaisseau->setEtat(false);
        $message = $vaisseau->interaction("consommationEnergie", 50);
        $this->assertStringContainsString("non opérationnel", $message);

    }
    public function testRempliEnergie(){
        $vaisseau = new Vaisseaux("Millenium", 100);
        $vaisseau->setCarburant(10);
        $vaisseau->interaction("rempliEnergie");
        $this->assertEquals(100, $vaisseau->getCarburant());
    }
    public function testSimulateurAvaries(){
        $vaisseau = new Vaisseaux("Millenium", 100);
        $vaisseau->setCarburant(0);
        $vaisseau->simulateurAvaries();
        $this->assertFalse($vaisseau->getEtat());
    }

    public function testReparation(){
        $vaisseau = new Vaisseaux("Millenium", 100);
        $vaisseau->setDegatSubies(100);
        $vaisseau->reparation();
        $this->assertTrue($vaisseau->getEtat());
    }

    /* Vaisseau transport */

    public function testVaisseauCharge() {
        $vaisseau = new VaisseauxTransport("Millenium", 100, 30);
        $vaisseau->charger(20);
        $this->assertEquals(20, $vaisseau->getChargeActuelle());
        $vaisseau->decharger(20);
        $this->assertEquals(0, $vaisseau->getChargeActuelle());
    }
    public function testChargementValide()
    {
        $vaisseau = new VaisseauxTransport(
            "Cargo Alpha",
            50,    
            100   
        );

        $vaisseau->charger(30);

        $this->assertEquals(30, $vaisseau->getChargeActuelle());
    }

    public function testChargementRefuseSiCapaciteDepassee()
    {
        $this->expectException(RuntimeException::class);
        $vaisseau = new VaisseauxTransport(
            "Cargo Gamma",
            80,
            50
        );

        $vaisseau->charger(60);
    }

    public function testDechargementValide()
    {
        $vaisseau = new VaisseauxTransport(
           
            "Cargo Delta",
            80,
            100
        );

        $vaisseau->charger(40);
        $vaisseau->decharger(10);

        $this->assertEquals(30, $vaisseau->getChargeActuelle());
    }

    public function testDechargementRefuseSiQuantiteInvalide()
    {
        $vaisseau = new VaisseauxTransport(
            
            "Cargo Epsilon",
            80,
            100
        );

        $this->expectException(RuntimeException::class);

        $vaisseau->decharger(10);
    }

    /* Vaisseau combat */

    public function testConsommationMunitions() {
        $this->expectException(\RuntimeException::class);
        $vaisseau = new VaisseauxCombat("Millenium", 0, 100);
        $this->assertTrue($vaisseau->tirer('40'));
        $this->assertEquals(60, $vaisseau->getMunitions());

        
        $vaisseau->setEtat(false);
        $vaisseau->tirer('10');
    }

    /* Utilisation de Data Provider */

    public static function invalidMunitionsProvider() {
        return [
            [-10, 100],
            [200, 100],
            [0, 100],
            [0, 0],
        ];
    }

    #[dataProvider('invalidMunitionsProvider')]
    public function testTirerLanceExceptionPourMunitionsInvalides($munitionsEnvoyees, $munitionsEnStock) {
        $this->expectException(\InvalidArgumentException::class);
        
        $vaisseau = new VaisseauxCombat("Millenium", 100, $munitionsEnStock);
        $vaisseau->tirer($munitionsEnvoyees);
    }
}