<?php

//avant PHP 8
class AnimalOld{
    private string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    public function __toString(): string
    {
        return "Mon nom est $this->name";
    }

    public function getName(): string
    {

        return $this->name;

    }
}

//version 8 de php
//les propriétés déclarées avec une visibilité  dans une méthode sont automatiquement des propriétés d'objet.
// depuis php 8.0, il est conseillé d'implémenter l'interface Stringable explicitement lors de l'appel à la méthode __toString. Si ce n'est pas fait, elle sera implémentée implicitement.
class Animal implements Stringable {

    public function __construct(private string $name)
    { }

    public function __toString(): string
    {
        return "Mon nom est $this->name";
    }

    public function getName(): string
    {
        return $this->name;
    }
}

//affichage
$dragon1 = new Animal('Viserion');
echo $dragon1;
echo '<br/>';
$dragon2 = new Animal('Drogon');
echo "Le nom de cet animal est {$dragon2->getName()}";
