<?php

class Person{

    public function __construct(private ?Animal $animal = null)
    {
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): void
    {
        $this->animal = $animal;

        //on affecte à l'animal la personne qui l'utilise
        $animal->setPerson($this); //<1>
    }

}

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
$dragon = new Animal();

//l'objet responsable de la mise à jour est l'instance de Person
//on affecte l'animal à John (la méthode setAnimal de John va s'occuper d'affecter à l'animal son utilisateur)
$john->setAnimal($dragon);

$dragon->getPerson(); // c'est John !

//tag::erreur_courante[]

$john = new Person();
$dragon = new Animal();

//un  animal n'est pas l'objet responsable de la mise à jour de l'objet lié
$dragon->setPerson($john);

//John ne connaît pas l'animal qu'il utilise !
$john->getAnimal(); //NULL
//end::erreur_courante[]
