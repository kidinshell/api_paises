<?php
namespace App\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\Persistence\ManagerRegistry;

class CountryManager
{
    private $doctrine;
    private $countryRepository;

    public function __construct(ManagerRegistry $doctrine, CountryRepository $countryRepository ) {

        $this->countryRepository = $countryRepository;
    }

    public function find(int $id): ?Country {
        return $this->countryRepository->find($id);
    }

    public function create(): Country {
        $country = new Country();
        return $country;
    }

    public function save(Country $country): Country {
        $this->doctrine->getManager()->persist($country);
        $this->doctrine->getManager()->flush();

        return $country;
    }
}