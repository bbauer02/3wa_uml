<?php
//tag::vehicleold[]
class VehicleOld {
    //un attribut contient une instance de l'entité lié. C'est ce qui permet depuis une instance de Vehicle d'accéder / naviguer / utiliser l'instance de Technician.
    private Technician $technician;
    //un véhicule est forcément associé à un technicien du fait de l'affectation via le constructeur
    public function __construct(Technician $t){
        $this->technician = $t;
    }

    //on peut affecter un autre technicien
    public function setTechnician(Technician $t): void
    {
        $this->technician = $t;
    }

    //navigabilité : on peut accéder au technicien depuis le véhicule courant
    public function getTechnician() : Technician
    {
        return $this->technician;
    }
}
//end::vehicleold[]
class Vehicle
{
    //le paramètre est promu en tant qu'attribut d'objet puisqu'il est déclaré avec une visibilité.
    public function __construct(private Technician $technician)
    {
    }

    //on peut affecter un autre technicien
    public function setTechnician(Technician $t): void
    {
        $this->technician = $t;
    }

    //navigabilité : on peut accéder au technicien depuis le véhicule courant
    public function getTechnician(): Technician
    {
        return $this->technician;
    }
}

class Technician{}

$vehicle = new Vehicle(); //erreur fatale. Un véhicule doit obligatoirement être associé à un technicien.
