<?php
//tag::class_Vehicle[]
class Vehicle
{
    /**
     * @param array|Technician[] $technicians collection d'objets de type
     *                                        Technician
     */
    public function __construct(
        private array $technicians = []
    ) {
        $this->setTechnicians($this->technicians);

    }

    //mutateurs et accesseur de la collection de techniciens

    //tag::class_Vehicle_addTechnician[]
    /**
     * @param Technician $technician ajoute un item de type Technician à la
     *                               collection
     */
    public function addTechnician(Technician $technician): bool
    {
        if (!in_array($technician, $this->technicians, true)) {
            $this->technicians[] = $technician;
            //tag::class_Vehicle_maj_objet_lie[]

            //mise à jour de l'objet lié <1>
            $technician->addVehicle($this);

            //end::class_Vehicle_maj_objet_lie[]

            return true;
        }

        return false;
    }
    //end::class_Vehicle_addTechnician[]

    //tag::class_Vehicle_removeTechnician[]
    /**
     * @param Technician $technician retire l'item de la collection
     */
    public function removeTechnician(Technician $technician): bool
    {
        $key = array_search($technician, $this->technicians, true);

        if ($key !== false) {
//tag::class_Vehicle_maj_objet_lie[]

            //mise à jour de l'objet lié (on indique au technicien qu'il n'est plus lié à la voiture courante
            // cette mise à jour est à faire AVANT la suppression du technicien sans quoi il ne sera pas possible de l'utiliser pour retirer le véhicule <2>
            $this->technicians[$key]->removeVehicle($this);
            //suppression du technicien (à faire après avoir retiré le véhicule qui lui était associé
//end::class_Vehicle_maj_objet_lie[]
            unset($this->technicians[$key]);

            return true;
        }

        return false;
    }
    //end::class_Vehicle_removeTechnician[]

    //tag::method_setTechnicians[]
    /**
     * Initialise la collection avec la collection passée en argument
     *
     * @param array $technicians collection d'objets de type Technician
     *
     * @return $this
     */
    public function setTechnicians(array $technicians): self
    {
        //tag::class_Vehicle_maj_objet_lie[]
        //mise à jour des objets de la collection courante (avant son actualisation)
        foreach($this->technicians as $technician){
            $technician->removeVehicle($this); //<2>
        }
        //end::class_Vehicle_maj_objet_lie[]

        //mise à jour de la collection de techniciens
        foreach ($technicians as $technician) {
            $this->addTechnician($technician);
        }

        return $this;
    }
    //end::method_setTechnicians[]
    /**
     * @return Technician[]
     */
    public function getTechnicians(): array
    {
        return $this->technicians;
    }
}
//end::class_Vehicle[]
//tag::class_Technician[]
class Technician
{
    /**
     * @param array $vehicles tableau d'objets de type Vehicle
     */
    public function __construct(
        private array $vehicles = []
    ) {
        
        $this->setVehicles($vehicles);

    }

    //mutateurs et accesseurs pour la collection de Vehicle

    /**
     * @param Vehicle $vehicle ajoute un item de type Vehicle à la collection
     */
    public function addVehicle(Vehicle $vehicle): bool
    {
        if (!in_array($vehicle, $this->vehicles, true)) {
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
        foreach ($vehicles as $vehicle) {
            $this->addVehicle($vehicle);
        }

        return $this;
    }


    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

}

//end::class_Technician[]
//tag::class_Intervention[]
class Intervention
{
    /**
     * @param string $descriptionIntervention
     * @param bool   $isResolved
     */
    public function __construct(
        private string $descriptionIntervention,
        private bool $isResolved
        //tag::class_Intervention_nav_to_Vehicle[]
        ,
        private Vehicle $vehicle
        //end::class_Intervention_nav_to_Vehicle[]

        //tag::class_Intervention_nav_to_Technician[]
        ,
        private Technician $technician
        //end::class_Intervention_nav_to_Technician[]
    )
    {
    }

    //tag::class_Intervention_nav_to_Vehicle[]

    //accesseur pour le véhicule
    /**
     * @return Vehicle
     */
    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    //mutateur pour le véhicule (on pourrait ne pas avoir de mutateur car le véhicule est affecté à l'intervention au moment de l'instanciation de cette dernière). Laisse le mutateur permet de modifier le véhicule associé (suite à une erreur de saisi par exemple)
    /**
     * @param Vehicle $vehicle
     */
    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;

        //tag::class_Intervention_maj_inverse_vehicule[]
//        $vehicle->addIntervention()
        //end::class_Intervention_maj_inverse_vehicule[]
    }
    //end::class_Intervention_nav_to_Vehicle[]

    //tag::class_Intervention_nav_to_Technician[]
    /**
     * @return Technician
     */
    public function getTechnician(): Technician
    {
        return $this->technician;
    }

    /**
     * @param Technician $technician
     */
    public function setTechnician(Technician $technician): void
    {
        $this->technician = $technician;
    }
    //end::class_Intervention_nav_to_Technician[]
    //mutateurs et accesseurs des attributs Intervention::descriptionIntervention et Intervention::isResolved

}


//end::class_Intervention[]



//tag::meo[]


//Mise en oeuvre des classes

//création des objets à associer
$batmobile = new Vehicle();
$bruce = new Technician();

//création d'une instance associative
$intervention = new Intervention($batmobile, $bruce);
$intervention->setDescriptionIntervention('Changement des lasers');
$intervention->setIsResolved(true);

//si l'on souhaite connaître les interventions du véhicule, nous aurons également accès au technicien de chaque intervention
$interventionsOfBatmobile = $batmobile->getInterventions();
//si on veut la description de la première intervention de la collection
$interventionDescription = $interventionsOfBatmobile[0]->getDescriptionIntervention(
);


//même remarque
$interventionsOfBruce = $bruce->getInterventions(); ////Changement des lasers

//si on veut savoir si la première intervention de la collection a résolu le problème :
$intervention1IsResolved = $interventionsOfBruce[0]->isResolved();  // true


//end::meo[]
