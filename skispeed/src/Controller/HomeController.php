<?php


namespace App\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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


       return $this->render('Pages/home.html.twig', [
            "figures" => $figures,

       ]);   

    }
    
}