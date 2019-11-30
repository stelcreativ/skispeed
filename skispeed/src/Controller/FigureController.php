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
use App\Repository\FigureRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{

    /**
     * @Route("/{page}", requirements={"page" = "\d+"}, name="home")
     * @param int $page
     */


        public function index($page, ObjectManager $em)
        {
           $displayFigures = $em->getRepository(Figure::class)->$getFiguresList($page);
           $countFigures = $em->getRepository(Figure::class)->$countFigures(); 
        
           return $this->render('Pages/home.html.twig', [
                "displayFigures" => $displayFigures,
                "nbPages" => ceil($countFigures/6),
                "page" => $page
           ]);   

        }



    /**
     * @Route("/figure/{slug}/{page}", name="figure_view")
     */
        public function View(Request $request, ObjectManager $em, Figure $figure, $page)
        {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $figure = $this->getDoctrine()->getRepository(Figure::class)->findOneBy(['slug' => $slug]);
    
        if ($form->isSubmitted() && $form->isValid())
        {
            $comment->setFigure($figure);
            $comment->setUser($user);

            $em->persist($comment);
            $em->flush();

            $this->addFlash("success", "Votre commentaire a bien été ajouté!");
            return $this->redirectToRoute('figure_view', [
                'slug' => $figure->getSlug()
            ]);
        }

        return $this->render('figure/view.html.twig', [
            'form' => $form->createView(),
            'figure' =>$figure,
            'nbpages' =>ceil($countComments /6),
            'page' => $page

        ]);

    }


    /**
     * @Route("/figure/create", name="figure_create")
     * 
     */
    public function create(Request $request, ObjectManager $em, uploader $uploader)
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);
        $image = new Image();
        $image_form =  $this->createForm(ImageType::class, $image);

        $video = new Video();
        $video_form = $this->createForm(VideoType::class, $video);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach($figure->getImages() as $image)
            {
      
                $image->setFigure($figure);
                $image = $uploader->upload($image);
                $manager->persist($image);
            }

            foreach($figure->getVideos() as $video)
            {
                $video->setFigure($figure);
                $em->persist($video);
            }

            $figure->setCreatedAt(new \DateTime());
            $figure->setUser($this->getUser());


            $em->persist($figure);
            $em->flush();

            $this->addFlash('success', 'La figure a bien été créée!');
            return $this->redirectToRoute('home');
        }

        return $this->render('figure/create.html.twig', 
        ['form' => $form->createView(),
         'video_form' => $video_form->createView(),
         'image_form' => $image_form->createView()
        ])
        
        ;

    }



    /**
     * @Route("/figure/edit/{slug}", name="figure_edit")
     */

    public function edit(Request $request, figureRepository $repo, ObjectManager $em, $slug)
    {

    $figure =$repo->findOneBySlug($slug);

    $form =$this->createForm(FigureType::class, $figure);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())

    {
        foreach($figure->getImages() as $image)
        {
            $image->setFigure($figure);
            $em->persist($image);
        }
        $em->persist($figure);
        $em->flush();

        $this->addFlash(
            'success', 'Lafigure a bien été modifiée!'
        );

        return $this->redirectToRoute('figure/view', [
            'slug' => $figure->getSlug()
        ]);
    }    
    return $this->render('figure/edit.html.twig', [
        'form' => $form->createView(),
        'figure' => $figure
    ]);  
}

    /**
     * @Route("/figure/delete/{slug}", name="figure_delete")
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
    ->setAction($this->generateUrl('figure_delete', ['slug' => $figure->getSlug()]))
    ->setMethod('DELETE')
    ->getForm();
}

}