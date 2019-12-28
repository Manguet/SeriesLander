<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action' => [
            'icon'        => 'fas fa-fighter-jet',
            'description' => 'Le film d\'action est un genre cinématographique qui met en scène une succession de 
                            scènes spectaculaires souvent stéréotypées (courses-poursuites, fusillades, explosions…) 
                            construites autour d\'un conflit résolu de manière violente, généralement par la mort des 
                            ennemis du héros. ',
        ],
        'Aventure' => [
            'icon'        => 'fas fa-khanda',
            'description' => 'Le film d\'aventures est un genre cinématographique caractérisé par la présence d\'un 
                              héros fictif ou non, tirant son statut du mythe qu\'il inspire, l\'action particulière 
                              qui s\'y déroule, l\'emploi de décors particuliers également, parfois le décalage 
                              temporel par rapport au contemporain ainsi que, parfois, les invraisemblances voulues 
                              caractérisant ainsi son excentricité, le tout véhiculant une idée générale de dépaysement',
        ],
        'Animation' => [
            'icon'        => 'fas fa-dog',
            'description' => 'L’animation, dans le domaine de l’audiovisuel, est un ensemble de techniques qui ont été
                              mises au point à partir du XIXe siècle, d\'abord par la reprise du principe de la bande 
                              dessinée et l\'utilisation de procédés optiques et mécaniques ne dépassant pas deux 
                              secondes dans leur représentation (jouet optique, folioscope), puis, dès 1892, par le 
                              perfectionnement de ces procédés en permettant des durées de représentation plus 
                              importantes, de une à cinq minutes (Théâtre optique), et par l\'utilisation en 1906 de 
                              la prise de vues image par image sur un support linéaire, la pellicule photographique 
                              (dessin animé, animation en volume), et enfin, à partir des années 1970, par l\'adoption 
                               procédés informatiques (animation par ordinateur, jeux vidéo).',
        ],
        'Comédie' => [
            'icon'        => 'fas fa-laugh-squint',
            'description' => 'La comédie est, au cinéma, un genre cinématographique dont une des caractéristiques
                             majeure est l\'humour.',
        ],
        'Drame' => [
            'icon'        => 'far fa-sad-tear',
            'description' => 'Le drame est un genre cinématographique qui traite des situations généralement non épiques
                              dans un contexte sérieux, sur un ton plus susceptible d\'inspirer la tristesse que le
                              rire.',
        ],
        'Fantastique' => [
            'icon'        => 'fas fa-dragon',
            'description' => 'Le cinéma fantastique est un genre cinématographique regroupant des films faisant appel 
                              au surnaturel, à l\'horreur, à l\'insolite ou aux monstres. L\'intrigue se fonde sur des 
                              éléments irrationnels, ou irréalistes.',
        ],
        'Horreur' => [
            'icon'        => 'fas fa-pastafarianism',
            'description' => 'Le film d\'horreur, ou film d\'épouvante, est un genre cinématographique dont l\'objectif
                              est de créer un sentiment de peur, de répulsion ou d\'angoisse chez le spectateur.',
        ],
        'Science-Fiction' => [
            'icon'        => 'fab fa-old-republic',
            'description' => 'Comme son nom l\'indique, elle consiste à raconter des fictions reposant sur des progrès 
                             scientifiques et techniques obtenus dans un futur plus ou moins lointain (il s\'agit alors 
                             également d\'anticipation), parfois dans un passé fictif ou dans un univers parallèle au 
                             nôtre, ou des progrès physiquement impossibles, du moins en l\'état actuel de nos 
                             connaissances. Elle met ainsi en œuvre les thèmes devenus classiques du voyage dans le 
                             temps, du voyage interplanétaire ou interstellaire, de la colonisation de l\'espace, de la 
                             rencontre avec des extra-terrestres, de la confrontation entre l\'espèce humaine et ses 
                             créations, notamment les robots et les clones, ou de la catastrophe apocalyptique 
                             planétaire.',
        ],
        'Thriller' => [
            'icon'        => 'fas fa-diagnoses',
            'description' => 'Le thriller (anglicisme, de l\'anglais to thrill : « frémir ») est un genre artistique 
                             utilisant le suspense ou la tension narrative pour provoquer chez le lecteur ou le 
                             spectateur une excitation ou une appréhension et le tenir en haleine jusqu\'au dénouement 
                             de l\'intrigue.',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::CATEGORIES as $name => $data) {
            $category = new Category();

            $category->setName($name);
            $category->setIcon($data['icon']);
            $category->setDescription($data['description']);
            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
            $i++;
        }
        $manager->flush();
    }
}
