<?php

//selon les recommandations PHP, lorsque la méthode __toString est utilisée, il faut implémenter l'interface Stringable.
class Vehicle implements Stringable
{

    //Déclaration des variables d'objet
    /**
     * @var string numéro d'immatriculation du véhicule
     */
    private string $registrationNumber;
    /**
     * @var int nombre de roues
     */
    private int $nbWheels;
    /**
     * @var string couleur du véhicule
     */
    private string $color;
    /**
     * @var string type de moteur (essence, diesel, électrique, hydrogène, ...)
     */
    private string $typeEngine;
    /**
     * @var int Position du véhicule
     */
    private int $position = 0;

    //le constructeur aurait pu être omis puisqu'il n'exécute aucun code
    public function __construct()
    {
    }



    //region ****** Mutateurs et accesseurs ******

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @return int
     */
    public function getNbWheels(): int
    {
        return $this->nbWheels;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getTypeEngine(): string
    {
        return $this->typeEngine;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param string $registrationNumber
     *
     * @return Vehicle
     */
    public function setRegistrationNumber(string $registrationNumber): Vehicle
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    /**
     * @param int $nbWheels
     *
     * @return Vehicule
     */
    public function setNbWheels(int $nbWheels): self
    {
        $this->nbWheels = $nbWheels;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return Vehicule
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $typeEngine
     *
     * @return Vehicule
     */
    public function setTypeEngine(string $typeEngine): self
    {
        $this->typeEngine = $typeEngine;

        return $this;
    }

    //endregion ****** Mutateurs et accesseurs ******


    //region ****** Autres opérations ******

    public function __toString(): string
    {
       return "Immatriculation : {$this->registrationNumber} ; Nombre de roues : {$this->nbWheels} ; couleur : {$this->color} ; type de moteur {$this->typeEngine} ; position : {$this->position}";
    }


    public function moveForward(int $nbKms): self
    {
        $this->position += $nbKms;

        return $this;
    }

    public function moveBack(int $nbKms): self
    {
        $this->position -= $nbKms;

        return $this;
    }

    //endregion ****** Autres opérations ******


}

$v1 = new Vehicle();
$v1->setRegistrationNumber('AAAA')->setNbWheels(4)->setColor('Jaune')->setTypeEngine('diesel');
$v1->moveForward(100)->moveForward(50)->moveBack(30);

$v2 = new Vehicle();
$v2->setRegistrationNumber('BBBB')->setNbWheels(2)->setColor('Rouge')->setTypeEngine('essence');
$v2->moveForward(230)->moveBack(50)->moveBack(10)->moveForward(140);

//mobilisation de la méthode toString en affichant directement les objets avec echo (normalement, il n'est pas possible d'afficher un élément non scalaire (une chaîne, un entier) de cette façon)
echo "==== DEBUT DU TEST EXERCICE 1 ==== \n";
echo "Voiture 1 : $v1";
echo "\n";
echo "Voiture 1 : $v2";
echo "\n==== FIN DU TEST EXERCICE 1 ====";






