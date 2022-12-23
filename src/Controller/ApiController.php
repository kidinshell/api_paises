<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Country;
use Doctrine\Persistence\ManagerRegistry;


class ApiController extends AbstractController
{
    /** DIRIGE A LA PÁGINA DONDE SE LISTAN LOS PAISES RECIBIDOS POR LA API */
    public function index(): Response
    {  
        $countryArray = $this->CountryList();
        
        return $this->render('country/api-view.html.twig', [
            'data' => $countryArray
        ]);
    }

    /** CARGA LOS PAÍSES DE LA API A LA BASE DE DATOS (SÓLO LOS NO EXISTENTES) */
    public function upload(ManagerRegistry $doctrine) {

        $country_repo = $doctrine->getRepository(Country::class);
        $countryList = $this->CountryList();
        $em = $doctrine->getManager();  

        foreach ($countryList as $data) {

            $country = new Country();
            $country->setCountryName($data['nombre']);
            $country->setCountryCode($data['code']);
            $country->setCountryCapital($data['capital']);
            $country->setCountryFlag($data['flag']);
            $country->setCountryPopulation($data['population']);
            $country->setApiId($data['apiId']);
        
            $countryMatch = $country_repo->findOneBy(
                array('apiId' => $data['apiId'])
            );

            if(!$countryMatch) {
                $em->persist($country);
                $em->flush();
            }
            
        }
        
        //Velve al Index con un mensaje
        $country_repo = $doctrine->getRepository(Country::class);
        $countrys = $country_repo->findBy([], ['id' => 'DESC']);

        return $this->render('country/index.html.twig', [
            'countrys' => $countrys,
            'msg' => 'Paises Cargados Correctamente'

        ]);
        
    }

    /** CONSUME LA API Y DEVUELVE EL ARRAY */
    public function allApiCountry(){
        $countrys_url = 'https://restcountries.com/v3.1/all';
        $countryData = file_get_contents($countrys_url);
        $countryData = json_decode($countryData);

        return $countryData;
    }

    /** CONSTRUYE LA LISTA CON LOS CAMPOS DESEADOS */
    public function CountryList() {

        $countryData = $this->allApiCountry();

         $data = [];
 
         foreach ($countryData as $country){

             $data[$country->cca3]['nombre'] = $country->name->common;
 
             if(isset($country->capital['0'])){
                 $data[$country->cca3]['capital'] = $country->capital['0'];
             }else{
                 $data[$country->cca3]['capital'] = 'Capital Not Found';
             }
 
             $data[$country->cca3]['code'] = $country->cca3;
             $data[$country->cca3]['population'] = $country->population;
             $data[$country->cca3]['flag'] = $country->flags->png;
             $data[$country->cca3]['apiId'] = $country->cca3;
 
         }

         return $data;

    }

    /** DESCARGA LA INFORMACIÓN DE UN PAIS DE LA BASE DE DATOS CON LA INFORMACIÓN DEL PAÍS EN LA API */
    public function downloadCountry($id, ManagerRegistry $doctrine){

            $request = $this->updateCountry($id, $doctrine);
            
            return $this->render('country/detail.html.twig', [
                'country' => $request[0],
                'msg' => $request[1]
            ]);

    }

    /**ACTUALIZA EL PAÍS SELECCIONADO CON LA INFORMACIÓN DE LA API */
    public function updateCountry($id, ManagerRegistry $doctrine){
        $em = $doctrine->getManager(); 
        $matchCountry = false;
        $message = ['text' =>'País No Encontrado en la Api', 'class' => 'warning'];
        $country_repo = $doctrine->getRepository(Country::class)->findOneBy(
                array('id' => $id)
            );

            $countryData = $this->allApiCountry();

            $api_country = new Country();           

                foreach ($countryData as $country){//CREA EL PAÍS CON LA INFORMACIÓN DE LA API

                    if($country->cca3 == $country_repo->getApiId()){
                        $matchCountry = true;
                        $api_country->setCountryName($country->name->common);
                        if(isset($country->capital['0'])){
                            $api_country->setCountryCapital($country->capital['0']);
                        }else{
                            $api_country->setCountryCapital('Capital Not Found');
                        }

                        $api_country->setCountryCode($country->cca3);
                        $api_country->setCountryPopulation($country->population);
                        $api_country->setCountryFlag($country->flags->png);
                        $message = ['text' =>'Descargada Información de la Api', 'class' => 'success'];
                    }

                }
            
                    //ACTUALIZA EL PAÍS EN LA BBDD SI HA ENCONTRADO EL CÓDIGO
                    if($matchCountry) {

                        $country_repo->setCountryName($api_country->getCountryName());
                        $country_repo->setCountryCode($api_country->getCountryCode());
                        $country_repo->setCountryCapital($api_country->getCountryCapital());
                        $country_repo->setCountryFlag($api_country->getCountryFlag());
                        $country_repo->setCountryPopulation($api_country->getCountryPopulation());
    
                        $em->persist($country_repo);
                        $em->flush();
                    }


            return [$country_repo, $message];
    }

}

