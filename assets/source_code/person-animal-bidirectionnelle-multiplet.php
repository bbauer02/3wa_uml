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
            $animal->setPerson($this); // <1>

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
            $animal->setPerson(null); // <2>
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

    public function __construct(private ?Person $person = null)
    {
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }
}

$john = new Person();
$dragon1 = new Animal();
$dragon2 = new Animal();
$dragon3 = new Animal();

$john->addAnimal($dragon1);
$john->addAnimal($dragon2);
$john->addAnimal($dragon3);

$dragon1->getPerson(); //John
$dragon2->getPerson(); //John
$dragon3->getPerson(); //John