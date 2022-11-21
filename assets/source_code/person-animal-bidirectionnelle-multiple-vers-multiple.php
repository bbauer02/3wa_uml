<?php

//responsable de la mise à jour des instances de la classe liée
class Person{

    /**
     * @param Animal[] $animals
     */
    public function __construct(private array $animals = [])
    {
    }

    /**
     * @param Animal $animal ajoute un item de type Animal à la collection
     */
    public function addAnimal(Animal $animal): bool
    {
        if (!in_array($animal, $this->animals, true)) {
            $this->animals[] = $animal;

            //mise à jour de l'objet inverse
            $animal->addPerson($this); // <1>

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

            //mise à jour de l'objet inverse
            $animal->removePerson($this); // <2>
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


}

//NON responsable de la mise à jour des instances de la classe liée
class Animal {

    /**
     * @param Person[] $persons  collection d'objets de type Person
     */
    public function __construct(private array $persons = [])
    {
    }

    /**
     * @param Person $person ajoute un item de type Person à la collection
     */
    public function addPerson(Person $person): bool
    {
        if (!in_array($person, $this->persons, true)) {
            $this->persons[] = $person;

            return true;
        }

        return false;
    }

    /**
     * @param Person $person retire l'item de la collection
     */
    public function removePerson(Person $person): bool
    {
        $key = array_search($person, $this->persons, true);

        if ($key !== false) {
            unset($this->persons[$key]);

            return true;
        }

        return false;
    }

    /**
     * @return Person[]
     */
    public function getPersons(): array
    {
        return $this->persons;
    }
    
    
}

$john = new Person();
$dragon1 = new Animal();
$dragon2 = new Animal();
$dragon3 = new Animal();

$john->addAnimal($dragon1);
$john->addAnimal($dragon2);
$john->addAnimal($dragon3);
//John n'utilise plus le dragon 3.
$john->removeAnimal($dragon3);

$dragon1->getPersons(); //tableau contenant une référence vers John
$dragon2->getPersons(); ////tableau contenant une référence vers John
$dragon3->getPersons(); //tableau vide