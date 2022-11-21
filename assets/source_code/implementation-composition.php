<?php

//tag::composition_classes[]
class Vehicle
{

    //dans une composition, les composants sont indispensables à la création du composite.
    //ils ne peuvent donc pas être null
    public function __construct(
        private Chassis $chassis,
        private Engine $engine
    ) {


    }

    public function __destruct()
    {
        echo "voiture détruite\n";
    }

    //ici les mutateurs et accesseurs des attributs d'objet
}

//tag::vehicle_2[]
class Vehicle2
{

    //déclaration des composants
    private Chassis $chassis;
    private Engine $engine;

    public function __construct()
    {
        //création des composants à la création du véhicule
        $this->chassis = new Chassis();
        $this->engine = new Engine();
    }

    //<1>
    //!!!ATTENTION!!!
    //IL NE DOIT PAS Y AVOIR DE MUTATEURS OU D'ACCESSEURS pour les variables qui référencent les composants car il ne doit pas être possible de manipuler ces composants depuis l'extérieur de la classe

    public function __destruct()
    {
        echo "voiture détruite\n";
    }

}

//end::vehicle_2[]

class Chassis
{

    public function __destruct()
    {
        echo "chassis détruit\n";
    }
}

class Engine
{
    public function __destruct()
    {
        echo "moteur détruit\n";
    }
}

//end::composition_classes[]

//tag::usage_1[]
$c = new Chassis();
$e = new Engine();

//création du composite
$v = new Vehicle($c, $e);

//destruction du véhicule
unset($v); //<1>
// à noter que détruire $v détruit également la référence stockée dans $this->chassis de $v (idem pour la référence au moteur ($this->engine)

//si une référence au chassis a été détruite avec l'objet véhicule, il reste la référence stockée dans la variable $c. Il faut donc la détruire également.
unset($c); //<2>
//même remarque pour le moteur
unset($e); //<2>
echo "\n---FIN DU SCRIPT---\n";

//A ce stade, le composite et ses composants sont détruits. Il n'est plus possible de les manipuler.

//end::usage_1[]

//tag::usage_2[]


//Les objets chassis et moteur qui composent la voiture ne sont pas référencés par d'autres variables que celles qui sont utilisées dans l'objet véhicule instancié
$v2 = new Vehicle(new Chassis(), new Engine());

//la destruction est alors très simple : il suffit de détruire l'objet véhicule
unset($v2);

echo "\n---FIN DU SCRIPT---\n";
//end::usage_2[]

//tag::usage_3[]

$v3 = new Vehicle2();

unset($v3);

echo "\n---FIN DU SCRIPT---\n";
//end::usage_3[]



