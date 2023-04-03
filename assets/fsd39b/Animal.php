<?php

class Animal implements Stringable {

    public function __construct(
        private ?string $name
    ){
    }

    public function __toString(): string
    {
        return 'Mon nom est '.$this->name;
    }

    public function getName():string|null{
        return $this->name;
    }
}

$joe = new Animal('joe');
$titi = new Animal ('Titi');
echo $joe;
echo "\n";
echo 'Mon nom est '.$titi->getName();