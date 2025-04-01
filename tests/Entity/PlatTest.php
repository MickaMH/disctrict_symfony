<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlatTest extends WebTestCase
{
    public function testGetPlatsCollection()
    {
        $client = static::createClient();
        $client->request('GET', '/api/plats');
        
        $this->assertResponseIsSuccessful();
        
        $responseContent = $client->getResponse()->getContent();
        $plats = json_decode($responseContent, true); // Décoder le JSON en tableau

        // Vérifiez que la réponse est un tableau
        $this->assertIsArray($plats);
        
        // Vérifiez le nombre d'éléments dans le tableau
        $this->assertCount(15, $plats); // Ajustez ce nombre selon vos données

        // Optionnel : Vérifiez que chaque plat a les propriétés attendues
        foreach ($plats as $plat) {
            $this->assertArrayHasKey('id', $plat);
            $this->assertArrayHasKey('libelle', $plat);
            $this->assertArrayHasKey('description', $plat);
            $this->assertArrayHasKey('prix', $plat);
            $this->assertArrayHasKey('image', $plat);
            $this->assertArrayHasKey('active', $plat);
        }
    }

    public function testGetPlat()
    {
        $client = static::createClient();
        $client->request('GET', '/api/plats/1');
        $this->assertResponseIsSuccessful();

        $responseContent = $client->getResponse()->getContent();
        
        $expectedJson = json_encode([
            'id' => 1,
            'libelle' => 'BURGER District',
            'description' => 'Burger composé d’un bun’s du boulanger, deux steaks de 80g (origine française), de deux tranches poitrine de porc fumée, de deux tranches cheddar affiné, salade et oignons confits.',
            'prix' => '8.00',
            'image' => 'hamburger.webp',
            'active' => true,
        ]);

        $this->assertJsonStringEqualsJsonString($expectedJson, $responseContent);
    }

    public function testPostPlat()
{
    $client = static::createClient();

    // Création d'un nouveau Plat avec l'en-tête Content-Type correctement défini
    $client->request('POST', '/api/plats', [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'categories'  => '/api/categories/1',
            'libelle'     => 'Plat Test',
            'description' => 'Ceci est un plat de test',
            'prix'        => '10.00',
            'image'       => 'plat-test.jpg',
            'active'      => true,
        ],
    ]);

    // Vérifie que la réponse a un code 2xx (succès)
    $this->assertResponseIsSuccessful();

    // Récupération et analyse de la réponse JSON
    $response = $client->getResponse();
    $data = json_decode($response->getContent(), true);

    // Contrôle que la réponse contient bien une clé "id"
    $this->assertArrayHasKey('id', $data, 'La réponse de création du plat ne contient pas la propriété "id".');
}



public function testPutPlat()
{
    $client = static::createClient();

    // Étape 1 : Créez un plat initial avec Content-Type défini en JSON.
    $client->request('POST', '/api/plats', [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'categories'  => '/api/categories/1',
            'libelle'     => 'Plat Original',
            'description' => 'Description originale',
            'prix'        => '10.00',
            'image'       => 'plat-original.jpg',
            'active'      => true,
        ],
    ]);

    // Vérifiez que le POST a réussi
    $this->assertResponseIsSuccessful();

    // Récupération des données retournées et vérification de la présence de la clé "id".
    $response = $client->getResponse();
    $data = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('id', $data, 'La réponse de création du plat ne contient pas la propriété "id".');
    $platId = $data['id'];

    // Étape 2 : Mise à jour du plat avec une requête PUT en précisant le Content-Type JSON.
    $client->request('PUT', '/api/plats/' . $platId, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'libelle'     => 'Plat Mis à Jour',
            'description' => 'Nouvelle description',
            'prix'        => 12.99,
            'image'       => 'plat-mis-a-jour.jpg',
            'active'      => false,
        ],
    ]);

    // Vérifiez que le PUT a réussi
    $this->assertResponseIsSuccessful();

    // Étape 3 : Récupération du plat mis à jour et vérifications des modifications.
    $client->request('GET', '/api/plats/' . $platId);
    $this->assertResponseIsSuccessful();
    $updatedData = json_decode($client->getResponse()->getContent(), true);

    $this->assertEquals('Plat Mis à Jour', $updatedData['libelle']);
    $this->assertEquals('Nouvelle description', $updatedData['description']);
    $this->assertEquals(12.99, $updatedData['prix']);
    $this->assertEquals('plat-mis-a-jour.jpg', $updatedData['image']);
    $this->assertFalse($updatedData['active']);
}


public function testPatchPlat()
{
    $client = static::createClient();

    // Étape 1 : Créer un plat initial avec Content-Type JSON.
    $client->request('POST', '/api/plats', [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'categories'  => '/api/categories/1',
            'libelle'     => 'Plat Original',
            'description' => 'Description originale',
            'prix'        => '10.00',
            'image'       => 'plat-original.jpg',
            'active'      => true,
        ],
    ]);

    $this->assertResponseIsSuccessful();

    // Récupération de la réponse et vérification de la présence de "id"
    $response = $client->getResponse();
    $data = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('id', $data, 'La réponse de création du plat ne contient pas la propriété "id".');
    $platId = $data['id'];

    // Étape 2 : Effectuer une requête PATCH pour mettre à jour partiellement le plat.
    // En ajoutant explicitement l'en-tête Content-Type: application/json.
    $client->request('PATCH', '/api/plats/' . $platId, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'libelle' => 'Plat Modifié',
            'prix'    => 15.99,
        ],
    ]);

    $this->assertResponseIsSuccessful();

    // Étape 3 : Vérifier que la mise à jour a été appliquée.
    $client->request('GET', '/api/plats/' . $platId);
    $this->assertResponseIsSuccessful();
    $updatedData = json_decode($client->getResponse()->getContent(), true);

    $this->assertEquals('Plat Modifié', $updatedData['libelle']);
    $this->assertEquals(15.99, $updatedData['prix']);
    // Vérification que les autres champs restent inchangés.
    $this->assertEquals('Description originale', $updatedData['description']);
}



public function testDeletePlat()
{
    $client = static::createClient();

    // Étape 1 : Créer un nouveau plat avec Content-Type défini en JSON.
    $client->request('POST', '/api/plats', [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'categories'  => '/api/categories/1',
            'libelle'     => 'Plat à Supprimer',
            'description' => 'Description du plat à supprimer',
            'prix'        => '20.00',
            'image'       => 'plat-a-supprimer.jpg',
            'active'      => true,
        ],
    ]);

    // Vérifie que la création a réussi
    $this->assertResponseIsSuccessful();

    // Récupère l'ID du plat créé
    $response = $client->getResponse();
    $data = json_decode($response->getContent(), true);
    $this->assertArrayHasKey('id', $data, 'La réponse de création du plat ne contient pas la propriété "id".');
    $platId = $data['id'];

    // Étape 2 : Envoyer une requête DELETE en définissant explicitement le Content-Type en JSON
    $client->request('DELETE', '/api/plats/' . $platId, [
        'headers' => [
            'Content-Type' => 'application/json',
        ],
    ]);

    // Vérifie que le DELETE a réussi
    $this->assertResponseIsSuccessful();

    // Étape 3 : Vérifier que le plat a bien été supprimé.
    // Une requête GET sur ce plat devrait renvoyer un code 404 (Not Found).
    $client->request('GET', '/api/plats/' . $platId);
    $this->assertResponseStatusCodeSame(404);
}


}