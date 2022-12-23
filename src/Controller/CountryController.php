<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Country;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\CountryType;

class CountryController extends AbstractController
{
    /** DIRIGE A LA PAGINA DONDE SE LISTAN LOS PAISES EN BASE DE DATOS */
    public function index(ManagerRegistry $doctrine): Response
    {
               
        $country_repo = $doctrine->getRepository(Country::class);
        $countrys = $country_repo->findBy([], ['id' => 'DESC']);

        return $this->render('country/index.html.twig', [
            'countrys' => $countrys
        ]);
    }

    /** MUESTRA EL DETALLE DEL PAÍS SELECCIONADO */
    public function detail(Country $country) {

        if(!$country){
            return $this->redirectToRoute('countrys');
        }else{
            return $this->render('country/detail.html.twig', [
                'country' => $country
            ]);
        }
        
    }

    /** CREA UN NUEVO PAÍS */
    public function creation(Request $request, ManagerRegistry $doctrine) {
        
        $country = new Country();

        $form = $this->createForm(CountryType::class, $country );
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
             
            $em = $doctrine->getManager();
            $em->persist($country);
            $em->flush();
            
            return $this->redirect(
                    $this->generateUrl('country_detail', ['id' => $country->getId()])
            );
        }
        
        return $this->render('country/creation.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
    /** EDITA UN PAÍS SELECCIONADO */
    public function edit(ManagerRegistry $doctrine, Request $request, Country $country) {
        
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($country);
            $em->flush();
            
            return $this->redirect(
                    $this->generateUrl('country_detail', ['id' => $country->getId()])
            );
        }
        
        return $this->render('country/creation.html.twig', [
            'edit' => true,
            'form' => $form->createView()
        ]);
    }
    
    /** ELIMINA DE LA LISTA UN PAÍS SELECCIONADO */
    public function delete(Country $country, ManagerRegistry $doctrine){
        
        if(!$country){
            return $this->redirectToRoute('countrys');
        }
        
        $em = $doctrine->getManager();
        $em->remove($country);
        $em->flush();
         return $this->redirectToRoute('countrys');
    }

}

