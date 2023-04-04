<?php
//tag::class_Technician[]
class Technician
{
    public function __construct(
        private string $name,
        private ?Vehicle $vehicle = null,
    ) {
    }

    /**
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle|null $vehicle
     *
     * @return Technician
     */
    //tag::method_setVehicle[]
    public function setVehicle(?Vehicle $vehicle): Technician
    {
        //tag::maj_inverse_vehicle[]
        //maj de l'objet inverse véhicule
        if (null !== $vehicle) {
            $vehicle->addTechnician($this);
        }

        //le véhicule précédemment associé au technician courant $this ne doit plus être associé à lui
        if (null !== $this->vehicle) {
            $this->vehicle->removeTechnician($this);
        }
        //end::maj_inverse_vehicle[]

        //on met à jour le nouveau véhicule associé au technicien courant $this
        $this->vehicle = $vehicle;


        return $this;
    }
    //end::method_setVehicle[]
}
//end::class_Technician[]
//tag::class_Vehicle[]
class Vehicle
{
    public function __construct(
        private string $registerNumber,
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

        $this->technicians = [];

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
echo "\n".'===================================================='."\n\n";
echo 'a) Créez deux instances de véhicules respectivement référencées par les variables `$vA` et `$vB`.'."\n Faire un `var_dump()` de chaque variable et noter l'identifiant propre à chaque objet (un identifiant est un `#` suivi d'un chiffre tel que `#1`)\n";

//tag::question_a[]
$vA = new Vehicle('AAAA');
$vB = new Vehicle('BBBB');

echo "-----------------------\n";
echo "*** var_dump de \$vA : \n";
echo "-----------------------\n";
var_dump($vA);
echo "L'identifiant de \$vA est #1. Le véhicule A n'est associé à aucun technicien.";

echo " \n-----------------------\n";
echo "*** var_dump de \$vB : \n";
echo "-----------------------\n";
var_dump($vB);
echo "L'identifiant de \$vB est #2. Le véhicule B n'est associé à aucun technicien.";
//end::question_a[]
echo "\n".'===================================================='."\n\n";
echo "b) Créez trois instances de technicien respectivement référencées par les variables `\$paul`, `\$juliette` et `\$jalila` (leur affecter le prénom correspondant aux noms des variables).\n";
echo "Faire un `var_dump()` de chaque technicien et noter l'identifiant d'objet qui leur est propre. \n";
//tag::question_b[]
$paul = new Technician('Paul');
$juliette = new Technician('Juliette');
$jalila = new Technician('Jalila');

echo "-----------------------\n";
echo "*** var_dump de \$paul : \n";
echo "-----------------------\n";
var_dump($paul);
echo "L'identifiant de \$paul est #3. Paul n'est associé à aucune voiture.";

echo "-----------------------\n";
echo "*** var_dump de \$juliette : \n";
echo "-----------------------\n";
var_dump($juliette);
echo "L'identifiant de \$juliette est #4. Juliette n'est associée à aucune voiture.";

echo "-----------------------\n";
echo "*** var_dump de \$jalila : \n";
echo "-----------------------\n";
var_dump($jalila);
echo "L'identifiant de \$jalila est #5. Jalila n'est associée à aucune voiture.";
//end::question_b[]

echo "\n".'===================================================='."\n\n";

echo "c) Associez le véhicule A aux techniciens Paul et Juliette et le véhicule B au technicien Jalila (il ne faut pas oublier que l'objet responsable de la mise à jour de l'objet lié est la technicien). ";
echo "\nFaire un var_dump de chaque véhicule afin de constater que la mise à jour de l'objet inverse (ici Vehicle) a été réalisée à partir de la classe Technician. Noter pour chaque voiture le ou les techniciens associés.";
//la classe propriétaire est Technician, les affectations doivent avoir lieu depuis les instances de celle-ci
//tag::question_c[]
$paul->setVehicle($vA);
$juliette->setVehicle($vA);
$jalila->setVehicle($vB);

echo "\n-----------------------\n";
echo "*** var_dump de \$vA : \n";
echo "-----------------------\n";
var_dump($vA);
echo "Le véhicule A (#1) est associé aux techniciens Paul et Juliette.\n";
echo "-----------------------\n";
echo "*** var_dump de \$vB : \n";
echo "-----------------------\n";
var_dump($vB);
echo "Le véhicule B (#2) est associé au technicien Jalila.\n";
//end::question_c[]

echo "\n".'===================================================='."\n\n";

echo "d) Associez le véhicule B au technicien Paul (sans oublier qui est la classe propriétaire). \nConstatez que le fait d'avoir affecté le véhicule B à Paul à produit trois effets : \n";
echo "- Paul n'est plus associé au véhicule A\n";
echo "- Le véhicule A n'est plus associé au technicien Paul mais encore à Juliette.\n";
echo "- Le véhicule B est associé au technicien Paul\n";
//tag::question_d[]
$paul->setVehicle($vB);

echo "-----------------------\n";
echo "*** var_dump de \$paul : \n";
echo "-----------------------\n";
var_dump($paul);
echo "L'identifiant de \$paul est #3. Paul n'est associé à aucune voiture.";

echo "\n-----------------------\n";
echo "*** var_dump de \$vA : \n";
echo "-----------------------\n";
var_dump($vA);
echo "Le véhicule A (#1) est encore associé à Juliette.\n";
echo "-----------------------\n";
echo "*** var_dump de \$vB : \n";
echo "-----------------------\n";
var_dump($vB);
echo "Le véhicule B (#2) est maintenant associé à Paul en plus de Jalila.\n";
//end::question_d[]
//end::meo_1[]
