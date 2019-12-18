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
use App\Service\Uploader;
use Cocur\Slugify\Slugify;
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\ObjectManager;
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
        $image = new Image();    
        $video = new Video();
        $form = $this->createForm(FigureType::class, $figure);
                $this->createForm(ImageType::class, $image);
                $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $image = $form['image']->getData();
            foreach($figure->getImages() as $image)
            {
      
                $image->setFigure($figure)
                    ->setName($figure->getSlug());
                $image = $uploader->upload($image);
                $em->persist($image);
            }

            foreach($figure->getVideos() as $video)
            {
                $video->setFigure($figure);
                $em->persist($video);
            }

            $figure->setCreatedAt(new \DateTime())
                    ->setSlug($figure->getName . '_style');
            $figure->setUser($this->getUser());

            $em = $this->getDoctrine()->getManager();



            $em->persist($figure);
            $em->flush();

            $this->addFlash('success', 'La figure a bien été créée!');
            return $this->redirectToRoute('figure_view', [
                'slug' => $figure->getSlug()
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

            $this->addFlash("success", "Votre commentaire a bien été ajouté!");
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
        $em->persist($figure);
        $em->flush();

        $this->addFlash(
            'success', 'Lafigure a bien été modifiée!'
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
    public function delete(Request $request, Figure $figure)
   {
    $form = $this->createDeleteForm($figure);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em = $this->remove($figure);
        $em->flush();

        $this->addFlash('success', 'La figure a bien été supprimée.');
        return $this->redirectToRoute('home');
    }
    return $this->render('figure/delete.html.twig.');
}

public function createDeleteForm(figure $figure)
{
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('figure_delete', ['id' => $figure->getId()]))
    ->setMethod('DELETE')
    ->getForm();
}

}