<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Figure;
use App\Entity\Comment;
use App\Form\ImageType;
use App\Form\VideoType;
use App\Form\FigureType;
use App\Form\CommentType;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\Uploader;
use Cocur\Slugify\Slugify;
use App\Controller\ObjectManager;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{

    /**
     * @Route("/figure/create", name="figure_create")
     * 
     */
    public function create(Request $request, EntityManagerInterface $em, uploader $uploader)
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {


            $figure = $form->getData();

            
        $figure->setCreatedAt(new \DateTime())
            ->setSlug($figure->getSlug() . 'style')
            ->setUser($this->getUser());



            $em = $this->getDoctrine()->getManager();

            $em->persist($figure);
            $em->flush();

            $this->addFlash('success', 'The trick has been created successfully!');
            return $this->redirectToRoute('figure_view', [
                'id' => $figure->getId()
            ]);
        }

        return $this->render('figure/create.html.twig', 
        ['form' => $form->createView(),

        ])
        
        ;

    }

    /**
     * @param Request $request
     * @Route("/figure/view/{id}", name="figure_view")
     */
        public function View(Request $request, figureRepository $repo, EntityManagerInterface $em, $id)
        {
           $figure = $em->getRepository(Figure::class)->findOneById($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

 
    
        if ($form->isSubmitted() && $form->isValid())
        {
             $comment->setContent();
            $comment->setCreatedAt(new \DateTime())
                    ->setFigure($figure)
                    ->setSlug($slug)
                    ->setUser($user);

            $em->persist($comment);
            $em->flush();

            $this->addFlash("success", "Your comment has been added!");
            return $this->redirectToRoute('figure/view.html.twig', [
                'figure' => $figure
            ]);
        }



        return $this->render('figure/view.html.twig', [
            'CommentForm' => $form->createView(),
            'figure' =>$figure,
            'comment' => $comment

        ]);

    }



    /**
     * @Route("/figure/edit/{id}", name="figure_edit")
     * @param  Figure $figure
     * @IsGranted("ROLE_USER")
     */

    public function edit(Request $request, figureRepository $repo, EntityManagerInterface $em, $id)
    {

    $figure = $em->getRepository(Figure::class)->findOneById($id);

    $form =$this->createForm(FigureType::class, $figure);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())

    {
        foreach($figure->getImage() as $image)
        {
            $image->setFigure($figure);
            $em->persist($image);
        }

        foreach($figure->getVideo() as $video)
        {
            $image->setFigure($figure);
            $em->persist($video);
        }       

        $em->persist($figure);
        $em->flush();

        $this->addFlash(
            'success', 'The trick has been modified successfully!'
        );

        return $this->redirectToRoute('figure_view', [
            'id' => $figure->getId(),

        ]);
    }    
    return $this->render('figure/edit.html.twig', [
        'form' => $form->createView(),
        'figure' => $figure
    ]);  
}

    /**
     * @Route("/figure/delete/{id}", name="figure_delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Figure $figure,  EntityManagerInterface $em, $id)
   {
    $figure = $em->getRepository(Figure::class)->findOneById($id);

    $filesystem = new Filesystem();

    foreach($figure->getImages() as $image)
    {
        $fileSystem->remove($image->getName());
    }    
    $em->remove($figure);
    $em->flush();

    $this->addFlash('success', 'The trick has been deleted.');

    return $this->redirectToRoute('home');
    }
}

