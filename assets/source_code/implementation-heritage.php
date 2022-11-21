<?php

//tag::file_class[]
class File
{

    //déclaration des attributs communs
    public function __construct(
        protected string $name,
        protected bool $isSecret = false
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isSecret(): bool
    {
        return $this->isSecret;
    }

    public function setIsSecret(bool $isSecret): void
    {
        $this->isSecret = $isSecret;
    }


    // méthodes commune
    public function isObsolete(): bool
    {
        //code qui renvoie true si l'age du document est > à 12 mois
        return false; //on décide de renvoyer false de façon arbitraire
    }

}

//end::file_class[]

//tag::filetext_class[]
class FileText extends File //<1>
{

    //la classe FileText n'a aucun attribut spécifique ni aucune méthode spécifiques

    //dans certains langages (en C# par exemple), il faut appeler le constructeur parent depuis la classe fille. En PHP, c'est implicite. <2>

    //elle hérite du code de la classe mère (c'est comme si le code de la classe mère était copié à l'intérieur de la classe fille sauf qu'il n'est pas nécessaire de le copier !)


}

//end::filetext_class[]
//tag::fileimage_class[]
class FileImage extends File // <1>
{

    //on n'ajoute que les attributs spécialisés
    private int $width;
    private int $height;

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    //ajout de la méthode spécialisée
    public function resize(): bool
    {
        //ici du code qui redimensionne l'image
        return true; //on considère que tout est ok
    }
}

//end::fileimage_class[]

//tag::file_executable_class[]
class FileExecutable extends File
{
    public function isValidate(){
        //code qui valide le fichier ou l'invalide
    }
}

//end::file_executable_class[]


//tag::file_media_class[]
class FileMedia extends File
{
    protected ?int $note = null;
}

//end::file_media_class[]

//tag::mise_en_oeuvre_heritage[]

//création d'un fichier texte
$fileText = new FileText("monFichierDeDonnees", false);
//nom du fichier (utilisation d'une méthode de la classe mère)
$fileName = $fileText->getName();
//le fichier texte est-il obsolète ?  (idem)
$fileTextIsObsolete = $fileText->isObsolete();

//création d'un fichier image
$fileImage = new FileImage("imageDuMarcheurBlanc", false);

//affectation des dimensions de l'image (utilisation des méthodes de la classe fille)
$fileImage->setHeight(800);
$fileImage->setWidth(600);

//l'image est-elle secrète ? (utilisation d'une méthode de la classe mère)
$imageIsSecret = $fileImage->isSecret();
//on redimensionne l'image (utilisation d'une méthode de la classe mère)
$resizeIsOk = $fileImage->resize();
//end::mise_en_oeuvre_heritage[]

//tag::fichier_executable[]
//Création d'un fichier exécutable (qui est avant tout un fichier)
$executableFile = new File("unVirus", true);

$fileExeAge = $executableFile->getAge();
$fileExeIsObsolete = $executableFile->isObsolete();
//end::fichier_executable[]

