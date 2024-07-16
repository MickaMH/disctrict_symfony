<?php

// src/Service/SearchService.php

namespace App\Service;

use App\Entity\Plat;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function searchPlatsByQuery($searchQuery): array
{
    if ($searchQuery === null) {
        $searchQuery = ''; // set a default value
    }

    if (!is_string($searchQuery)) {
        throw new \InvalidArgumentException('Search query must be a string');
    }

    $plats = $this->em->getRepository(Plat::class)->findPlatsBySearchQuery($searchQuery);

    return $plats;
}

    public function filterPlatsBySearchQuery(array $plats, string $searchQuery): array
    {
        $filteredPlats = [];

        foreach ($plats as $plat) {
            if (strpos(strtolower($plat->getLibelle()), strtolower($searchQuery)) !== false) {
                $filteredPlats[] = $plat;
            }
        }

        return $filteredPlats;
    }
}