<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Country;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\ApiService;


class ApiController extends AbstractController
{
    /** DIRIGE A LA PÁGINA DONDE SE LISTAN LOS PAISES RECIBIDOS POR LA API */
    public function index(ManagerRegistry $doctrine): Response
    {  
        $apiService = new ApiService($doctrine);
        $countryArray = $apiService->CountryList();

        return $this->render('country/api-view.html.twig', [
            'data' => $countryArray
        ]);
    }

    /** CARGA LOS PAÍSES DE LA API A LA BASE DE DATOS (SÓLO LOS NO EXISTENTES) */
    public function upload(ManagerRegistry $doctrine) {

        $apiService = new ApiService($doctrine);
        
        $upload = $apiService->upload();
        
        //Velve al Index con un mensaje
        $country_repo = $doctrine->getRepository(Country::class);
        $countrys = $country_repo->findBy([], ['id' => 'DESC']);

        return $this->render('country/index.html.twig', [
            'countrys' => $countrys,
            'msg' => 'Paises Cargados Correctamente'

        ]);
        
    }

    /** DESCARGA LA INFORMACIÓN DE UN PAIS DE LA BASE DE DATOS CON LA INFORMACIÓN DEL PAÍS EN LA API */
    public function downloadCountry($id, ManagerRegistry $doctrine){
            $apiService = new ApiService($doctrine);
            $request = $apiService->updateCountry($id);
            
            return $this->render('country/detail.html.twig', [
                'country' => $request[0],
                'msg' => $request[1]
            ]);

    }


}

