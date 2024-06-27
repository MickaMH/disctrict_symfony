<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Categorie;
use App\Entity\Plat;

class Jeu1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

/* CATEGORIES */

        $pizza = new Categorie();
        $pizza->setLibelle("Pizza");
        $pizza->setImage("pizza_cat.webp");
        $pizza->setActive("1");
        $manager->persist($pizza);

        $burger = new Categorie();
        $burger->setLibelle("Burger");
        $burger->setImage("burger_cat.webp");
        $burger->setActive("1");
        $manager->persist($burger);

        $wrap = new Categorie();
        $wrap->setLibelle("Wrap");
        $wrap->setImage("wrap_cat.webp");
        $wrap->setActive("1");
        $manager->persist($wrap);

        $pates = new Categorie();
        $pates->setLibelle("Pâtes");
        $pates->setImage("pates_cat.webp");
        $pates->setActive("1");
        $manager->persist($pates);

        $sandwich = new Categorie();
        $sandwich->setLibelle("Sandwich");
        $sandwich->setImage("sandwich_cat.webp");
        $sandwich->setActive("1");
        $manager->persist($sandwich);

        $asian_food = new Categorie();
        $asian_food->setLibelle("Asian Food");
        $asian_food->setImage("asian_food_cat.webp");
        $asian_food->setActive("0");
        $manager->persist($asian_food);

        $salade = new Categorie();
        $salade->setLibelle("Salade");
        $salade->setImage("salade_cat.webp");
        $salade->setActive("1");
        $manager->persist($salade);

        $veggie = new Categorie();
        $veggie->setLibelle("Veggie");
        $veggie->setImage("veggie_cat.webp");
        $veggie->setActive("1");
        $manager->persist($veggie);

        $boisson = new Categorie();
        $boisson->setLibelle("Boisson");
        $boisson->setImage("boisson_cat.webp");
        $boisson->setActive("1");
        $manager->persist($boisson);

/* PLATS */

        $district = new PLat();
        $district->setLibelle("BURGER District");
        $district->setDescription("Burger composé d’un bun’s du boulanger, deux steaks de 80g (origine française), de deux tranches poitrine de porc fumée, de deux tranches cheddar affiné, salade et oignons confits.");
        $district->setPrix("8.00");
        $district->setImage("hamburger.webp");
        $district->setActive("1");
        $manager->persist($district);
        $burger->addPlat($district);

        $bianca = new PLat();
        $bianca->setLibelle("PIZZA Bianca");
        $bianca->setDescription("Une pizza fine et croustillante garnie de crème mascarpone légèrement citronnée et de tranches de saumon fumé, le tout relevé de baies roses et de basilic frais.");
        $bianca->setPrix("14.00");
        $bianca->setImage("pizza_salmon.webp");
        $bianca->setActive("1");
        $manager->persist($bianca);
        $pizza->addPlat($bianca);

        $buffalo_chicken = new PLat();
        $buffalo_chicken->setLibelle("Wrap Buffalo Chicken");
        $buffalo_chicken->setDescription("Du bon filet de poulet mariné dans notre spécialité sucrée & épicée, enveloppé dans une tortilla blanche douce faite maison.");
        $buffalo_chicken->setPrix("5.00");
        $buffalo_chicken->setImage("chicken_wrap.webp");
        $buffalo_chicken->setActive("1");
        $manager->persist($buffalo_chicken);
        $wrap->addPlat($buffalo_chicken);

        $cheese = new PLat();
        $cheese->setLibelle("BURGER Cheese");
        $cheese->setDescription("Burger composé d’un bun’s du boulanger, de salade, oignons rouges, pickles, oignon confit, tomate, d’un steak d’origine Française, d’une tranche de cheddar affiné, et de notre sauce maison.");
        $cheese->setPrix("8.00");
        $cheese->setImage("cheeseburger.webp");
        $cheese->setActive("1");
        $manager->persist($cheese);
        $burger->addPlat($cheese);

        $spaghettis = new PLat();
        $spaghettis->setLibelle("PATES Spaghettis");
        $spaghettis->setDescription("Un plat de spaghetti au pesto de basilic et légumes poêlés, très parfumé et rapide");
        $spaghettis->setPrix("10.00");
        $spaghettis->setImage("spaghettis_legumes.webp");
        $spaghettis->setActive("1");
        $manager->persist($spaghettis);
        $pates->addPlat($spaghettis);

        $cesar = new PLat();
        $cesar->setLibelle("SALADE César");
        $cesar->setDescription("Une délicieuse salade Caesar (César) composée de filets de poulet grillés, de feuilles croquantes de salade romaine, de croutons à l'ail, de tomates cerise et surtout de sa fameuse sauce Caesar. Le tout agrémenté de copeaux de parmesan.");
        $cesar->setPrix("7.00");
        $cesar->setImage("cesar_salad.webp");
        $cesar->setActive("1");
        $manager->persist($cesar);
        $salade->addPlat($cesar);

        $margherita = new PLat();
        $margherita->setLibelle("PIZZA Margherita");
        $margherita->setDescription("Une authentique pizza margarita, un classique de la cuisine italienne! Une pâte faite maison, une sauce tomate fraîche, de la mozzarella Fior di latte, du basilic, origan, ail, sucre, sel & poivre...");
        $margherita->setPrix("14.00");
        $margherita->setImage("pizza_margherita.webp");
        $margherita->setActive("1");
        $manager->persist($margherita);
        $pizza->addPlat($margherita);

        $courgettes = new PLat();
        $courgettes->setLibelle("VEGGIE Courgettes farcies");
        $courgettes->setDescription("Voici une recette équilibrée à base de courgettes, quinoa et champignons, 100% vegan et sans gluten!");
        $courgettes->setPrix("8.00");
        $courgettes->setImage("courgettes.webp");
        $courgettes->setActive("1");
        $manager->persist($courgettes);
        $veggie->addPlat($courgettes);

        $lasagnes = new PLat();
        $lasagnes->setLibelle("PATES Lasagnes");
        $lasagnes->setDescription("Découvrez notre recette de lasagnes, l'une des spécialités italiennes que tout le monde aime avec sa viande hachée et gratinée à l'emmental. Et bien sûr, une inoubliable béchamel à la noix de muscade.");
        $lasagnes->setPrix("12.00");
        $lasagnes->setImage("lasagnes_viandes.webp");
        $lasagnes->setActive("1");
        $manager->persist($lasagnes);
        $pates->addPlat($lasagnes);

        $tagliatelles = new PLat();
        $tagliatelles->setLibelle("PATES Tagliatelles");
        $tagliatelles->setDescription("Découvrez notre recette délicieuse de tagliatelles au saumon frais et à la crème qui qui vous assure un véritable régal!");
        $tagliatelles->setPrix("12.00");
        $tagliatelles->setImage("tagliatelles_saumon.webp");
        $tagliatelles->setActive("1");
        $manager->persist($tagliatelles);
        $pates->addPlat($tagliatelles);

        $eau = new PLat();
        $eau->setLibelle("BOISSON Eau");
        $eau->setDescription("Bouteille de 0,5L");
        $eau->setPrix("2.00");
        $eau->setImage("eau.webp");
        $eau->setActive("1");
        $manager->persist($eau);
        $boisson->addPlat($eau);

        $gazeuse = new PLat();
        $gazeuse->setLibelle("BOISSON Gazeuse");
        $gazeuse->setDescription("Bouteille de 0,33cl");
        $gazeuse->setPrix("2.00");
        $gazeuse->setImage("gazeuse.webp");
        $gazeuse->setActive("1");
        $manager->persist($gazeuse);
        $boisson->addPlat($gazeuse);

        $orange = new PLat();
        $orange->setLibelle("BOISSON Orange");
        $orange->setDescription("Bouteille de 0,33cl");
        $orange->setPrix("2.00");
        $orange->setImage("orange.webp");
        $orange->setActive("1");
        $manager->persist($orange);
        $boisson->addPlat($orange);

        $cola = new PLat();
        $cola->setLibelle("BOISSON Cola");
        $cola->setDescription("Bouteille de 0,33cl");
        $cola->setPrix("2.00");
        $cola->setImage("cola.webp");
        $cola->setActive("1");
        $manager->persist($cola);
        $boisson->addPlat($cola);

        $printanier = new PLat();
        $printanier->setLibelle("SANDWICH Printanier");
        $printanier->setDescription("Des tendres filets de poulet marinés, herbes de Provence, tranches de tomate, salade fraîche.");
        $printanier->setPrix("5.00");
        $printanier->setImage("printanier_poulet.webp");
        $printanier->setActive("1");
        $manager->persist($printanier);
        $sandwich->addPlat($printanier);

        $manager->flush();
    }
}
