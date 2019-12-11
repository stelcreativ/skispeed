<?php


namespace App\Controller;

use App\Entity\Figure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\FigureRepository;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     * 
     * 
     */


    public function index(EntityManagerInterface $em, FigureRepository $repository):response
    {
        $figures =$repository->findAll();
    //   $displayFigures = $repository->getFiguresList($page);
      //  $countFigures = $repository->countFigures(); 


       return $this->render('Pages/home.html.twig', [
            "figures" => $figures,
         //   "displayFigures" => $displayFigures,
           // "nbPages" => ceil($countFigures/4),
          //  "page" => $page
       ]);   

    }

    
}