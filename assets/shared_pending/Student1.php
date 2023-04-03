<?php

class Group {
    public function __construct(private string $name)
    {
    }
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

class Student {
    public function __construct(
        private string $name,
        private int $age,
        private ?Group $group = null
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     */
    public function setGroup(?Group $group): void
    {
        $this->group = $group;
    }
}

//création de deux étudiants
$e1 = new Student('Joe',21);

//création d'un groupe
$g1 = new Group('fsd39b');

$e2 = new Student('Titi',34, $g1);
$e1->setGroup($g1);

//affichage du groupe de chaque étudiant
echo $e1->getGroup()->getName();
echo "\n";
echo $e2->getGroup()->getName();
