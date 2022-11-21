<?php

//tag::class_Technician[]
class Technician
{
    public function __construct(
        private array $vehicles = [],
    ) {

        $this->setVehicles($this->vehicles);
    }

    //tag::mutator_accessor_of_vehicle[]
    /**
     * @param Vehicle $vehicle ajoute un item de type Vehicle à la collection
     */
    public function addVehicle(Vehicle $vehicle): bool
    {
        if (!in_array($vehicle, $this->vehicles, true)) {

            //tag::maj_inverse_vehicle[]
            //mise à jour de l'objet inverse
            $vehicle->addTechnician($this); //<1>
            //end::maj_inverse_vehicle[]

            $this->vehicles[] = $vehicle;

            return true;
        }

        return false;
    }

    /**
     * @param Vehicle $vehicle retire l'item de la collection
     */
    public function removeVehicle(Vehicle $vehicle): bool
    {
        $key = array_search($vehicle, $this->vehicles, true);

        if ($key !== false) {

            //tag::maj_inverse_vehicle[]
            //mise à jour de l'objet inverse
            $vehicle->removeTechnician($this); //<1>
            //end::maj_inverse_vehicle[]

            unset($this->vehicles[$key]);

            return true;
        }

        return false;
    }
    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $vehicles collection d'objets de type Vehicle
     *
     * @return $this
     */
    public function setVehicles(array $vehicles): self
    {

    //tag::maj_inverse_vehicle[]
        //mise à jour des items de la collection avant qu'elle ne soit écrasée par la nouvelle
        foreach($this->vehicles as $vehicle) {
            $vehicle->removeTechnician($this); //<1>
        }
    //end::maj_inverse_vehicle[]

        //construction de la nouvelle collection
        foreach ($vehicles as $vehicle) {
            $this->addVehicle($vehicle);
        }

        return $this;
    }
    //end::mutator_accessor_of_vehicle[]

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

}

//end::class_Technician[]

//tag::class_Vehicle[]
class Vehicle
{
    public function __construct(
        private array $technicians = [],
    ) {

        $this->setTechnicians($this->technicians);
    }

    /**
     * @param Technician $technician ajoute un item de type Technician à la
     *                               collection
     */
    public function addTechnician(Technician $technician): bool
    {
        if (!in_array($technician, $this->technicians, true)) {
            $this->technicians[] = $technician;

            return true;
        }

        return false;
    }

    /**
     * @param Technician $technician retire l'item de la collection
     */
    public function removeTechnician(Technician $technician): bool
    {
        $key = array_search($technician, $this->technicians, true);

        if ($key !== false) {
            unset($this->technicians[$key]);

            return true;
        }

        return false;
    }

    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $technicians collection d'objets de type Technician
     *
     * @return $this
     */
    public function setTechnicians(array $technicians): self
    {
        foreach ($technicians as $technician) {
            $this->addTechnician($technician);
        }

        return $this;
    }

    /**
     * @return Technician[]
     */
    public function getTechnicians(): array
    {
        return $this->technicians;
    }


}
//end::class_Vehicle[]

//tag::meo_1[]
//a) Créez deux instances de véhicules respectivement référencées par les variables `$vA` et `$vB`.
$vA = new Vehicle();
$vB = new Vehicle();

//b) Créez trois instances de technicien respectivement référencées par les variables `$t1`, `$t2` et `$t3`.
$t1 = new Technician();
$t2 = new Technician();
$t3 = new Technician();

//c) Associez le véhicule A aux techniciens t1 et t2 et le véhicule B au technicien t3.

//la classe propriétaire est Technician, les affectations doivent avoir lieu depuis les instances de celle-ci
$t1->setVehicle($vA);
$t2->setVehicle($vA);
$t3->setVehicle($vB);

//d) Faire un `var_dump()` de chaque véhicule et repérer l'identifiant de ressource associé à chaque instance (un identifiant de ressource est noté `#` suivi d'un numéro. Cet identifiant est propre à chaque instance)
var_dump($vA); //#1 pour le véhicule A
var_dump($vB); //#2 pour le véhicule B

//e) Pour chaque identifiant véhicule, listez les identifiants des techniciens associés.
//véhicule #1 -- #3, #4
//véhicule #2 -- #5

//f) Associez le véhicule B aux techniciens t1 et t2.
$t1->setVehicle($vB);
$t2->setVehicle($vB);

//g) A ce stade, à combien de technicien doit être associé le véhicule A ? Et le véhicule B ?
//A est associé aux trois techniciens et B à aucun.

//h) Faire un `var_dump()` de chaque véhicule et repérer l'identifiant de ressource associé à chaque instance
var_dump($vA); //#1 pour le véhicule A
var_dump($vB); //#2 pour le véhicule B

//i) Pour chaque identifiant véhicule, listez les identifiants des techniciens associés afin de valider la réponse apportée à la question "g".
//véhicule #1 -- #5, #3, #4
//véhicule #2 -- aucun
//end::meo_1[]
