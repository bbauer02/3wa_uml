<?php

//tag::class_Person[]
class Person
{
    //variable d'objet stockant la collection d'objet de type Animal associé à la personne courante
    private array $animals = [];

    public function __construct(
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Person
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param Animal $animal ajoute un item de type Animal à la collection
     */
    public function addAnimal(Animal $animal): bool
    {
        if (!in_array($animal, $this->animals, true)) {
            $this->animals[] = $animal;

            //tag::maj_objet_lie_animal[]
            $animal->setPerson($this); //<1>
            //end::maj_objet_lie_animal[]

            return true;
        }

        return false;
    }

    /**
     * @param Animal $animal retire l'item de la collection
     */
    public function removeAnimal(Animal $animal): bool
    {
        $key = array_search($animal, $this->animals, true);

        if ($key !== false) {
            unset($this->animals[$key]);

            //tag::maj_objet_lie_animal[]
            $animal->setPerson(null); //<1>
            //end::maj_objet_lie_animal[]

            return true;
        }

        return false;
    }

    /**
     * @return Animal[]
     */
    public function getAnimals(): array
    {
        return $this->animals;
    }

    /**
     * Cherche dans la collection des animaux liés à la personne courante l'animal passé en argument
     *
     * @param Animal $animal
     *
     * @return bool true si l'animal figure dans la collection, false dans le cas contraire
     */
    public function contains(Animal $animal): bool
    {

        if (in_array($animal, $this->animals, true)) {
            return true;
        }

        return false;
    }



}

//end::class_Person[]
//tag::class_Animal[]
class Animal
{
    //variable d'objet stockant la personne associée à la personne courante
    private ?Person $person = null;

    public function __construct(
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Animal
    {
        $this->name = $name;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    //tag::method_setPerson[]
    public function setPerson(?Person $person): Animal
    {
        //tag::check_call_from_owning_entity[]
        //si l'animal courant $this ne doit pas être associé à une personne (l'argument $person est null), alors il faut s'assurer que si une personne lui était déjà associée, celle-ci ne doit plus avoir d'animal ou avoir un animal différent de l'animal courant $this. Sinon, cela signifie que la mise à jour n'est pas réalisée depuis l'objet possédant. Dans ce cas, une exception est levée
        if ($person === null) {
            //si la personne actuellement liée à l'animal courant $this a encore un animal et que celui-ci est l'animal courant, alors la mise à jour n'est pas réalisée depuis l'objet possédant.
            if ($this->person !== null && $this->person->contains($this)) {
                throw new Exception(
                    "La suppression d'un lien entre l'animal et la personne doit être réalisée depuis l'objet possédant via la méthode \"Person::removeAnimal()\""
                );
            }
        } else {
            //il faut affecter une personne à l'animal courant $this. Cette personne doit donc forcément déjà être associée à cet animal. Si ce n'est pas le cas, c'est que la mise à jour n'a pas lieu depuis l'objet possédant
            if ($person->getAnimal() !== $this) {
                throw new Exception(
                    "L'association d'un animal à une personne doit être effectuée avec \"Person::setAnimal()\""
                );
            }
        }
        //end::check_call_from_owning_entity[]

        $this->person = $person;

        return $this;
    }
    //end::method_setPerson[]

}

//end::class_Animal[]
//tag::meo_1[]
/*
$viserion = new Animal('Viserion');
$john = new Person('John Snow');

$john->setAnimal($viserion);

$animalDeJohn = $john->getAnimal(); //on navigue de la personne vers l'animal

var_dump($animalDeJohn); //instance de Animal (sans utilisateur)
//end::meo_1[]
//tag::meo_2[]

//on navigue de l'animal vers la personne <1>
$utilisateurDeViserion = $viserion->getPerson();

var_dump($utilisateurDeViserion); //null <2>
//end::meo_2[]
//tag::meo_3[]
$viserion->setPerson($john);

$utilisateurDeViserion = $viserion->getPerson();

var_dump($utilisateurDeViserion); //instance de John

var_dump($animalDeJohn); //instance de Animal

//end::meo_3[]
//tag::meo_4[]
$drogon = new Animal('Drogon');
$khaleesi = new Person('Khaleesi');

//Drogon est affecté à Khaleesi :
$khaleesi->setAnimal($drogon);

$utilisateurDeDrogon = $drogon->getPerson();

//qui est l'utilisateur de Drogon ?
var_dump($utilisateurDeDrogon); //Khaleesi

//Drogon est affecté à John :
$john->setAnimal($drogon);

//qui est l'utilisateur de Drogon ?
var_dump($utilisateurDeDrogon); //john
//end::meo_4[]
//tag::meo_5[]
echo "\n\n MEO 5 -----------\n\n";
$rhaegal = new Animal('Rhaegal');
$tyrion = new Person('Tyrion');

//association de Tyrion et du dragon Rhaegal
$tyrion->setAnimal($rhaegal);

//qui est l'utilisateur de Rhaegal ?
var_dump($rhaegal->getPerson()); //Tyrion

//Rhaegal est affectée à John
$john->setAnimal($rhaegal);

//qui est l'utilisateur de Rhaegal ?
var_dump($rhaegal->getPerson()); //John

//Quel animal est associé à Tyrion
var_dump($tyrion->getAnimal()); // NULL

//end::meo_5[]
//tag::meo_6[]
$drogon = new Animal('Drogon');
$john = new Person('John Snow');

$john->setAnimal($drogon);

var_dump($john->getAnimal()); //animal Drogon
var_dump($drogon->getPerson()); // personne John Snow

//on associe aucun animal à John
$john->setAnimal(null);

var_dump($john->getAnimal()); //null <1>

var_dump($drogon->getPerson()); // personne John Snow <2>
//end::meo_6[]
//tag::meo_7[]
$drogon = new Animal('Drogon');
$john = new Person('John Snow');

$john->setAnimal($drogon);

var_dump($john->getAnimal()); //animal Drogon
var_dump($drogon->getPerson()); // personne John Snow

//on associe aucun animal à John
$john->setAnimal(null);

var_dump($drogon->getPerson()); // null <2>
//end::meo_7[]
//tag::meo_8[]
$drogon = new Animal('Drogon');
$viserion = new Animal('Viserion');

$john = new Person('John Snow');

$john->setAnimal($drogon);
var_dump($drogon->getPerson()); // personne John Snow
var_dump($viserion->getPerson()); // null

//on associe un autre animal à John
$john->setAnimal($viserion);

var_dump($drogon->getPerson()); //  null <1>
*/
//end::meo_8[]
//tag::meo_9[]
$drogon = new Animal('Drogon');
$viserion = new Animal('Viserion');

$john = new Person('John Snow');

$john->setAnimal($drogon); //Ok, association depuis une personne

$drogon->setPerson(null); //Exception levée : tentative d'association depuis l'animal qui n'est pas l'objet possédant

$viserion->setPerson($john); //Exception levée : tentative d'association depuis l'animal qui n'est pas l'objet possédant
//end::meo_9[]
