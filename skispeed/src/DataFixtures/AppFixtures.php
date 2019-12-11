<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Figure;
use App\Entity\Comment;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
    $faker = \Faker\Factory::create('fr_FR');
    


    // 4 Users
    for ($i=0; $i<5; $i++)
    {
        $user = new User();
        $user -> setUsername($faker->userName)
            ->setEmail($faker->Email)
            ->setPassword(password_hash($faker->password, PASSWORD_BCRYPT))
            ->setCreatedAt($faker->dateTimebetween('-6 month'))
            ->setIsLogged(true)
            ->setResetToken(md5(random_bytes(10)));
        $em->persist($user);

    }


    // 8 figures
    for($i=0; $i<5; $i++)
    {
        $figure = new Figure();
        $figure->setName('bigair')
               ->setDescription('Il s\'agit d\'effectuer des figures dans les airs') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('bigair_style')
                ->setUser($user1);
                
                for($i=0; $i<5; $i++)
            {
            $image = new Image();
             $image->setUrl('images/uploads')
                   ->setName('bigair_sm.jpg') 
                   ->setFigure($figure);

            $em->persist($image);
            $figure->addImage($image);
            }

            for ($v=0; $v<mt_rand(1, 2); $v++)
            {
            $video =new Video();
            $video->setUrl('https://www.youtube.com/watch?v=z-gD3esFIm8')
             ->setFigure($figure);
            $em->persist($video);
            $figure->addVideo($video);
            }

            $em->persist($figure);      
        
        // nouvelle figure    
        $figure = new Figure();
        $figure->setName('flair')
               ->setDescription('Flip arrière avec une rotation latérale de 180°. Il s\'agit de sauter, tourner et atterrir.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('flair_style')
                ->setUser($user);

                for($i=0; $i<5; $i++)
                {
                $image = new Image();
                 $image->setUrl('images/uploads')
                       ->setName('flair_sm.jpg') 
                       ->setFigure($figure);
    
                $em->persist($image);
                $figure->addImage($image);
                }
    
                for ($v=0; $v<mt_rand(1, 2); $v++)
                {
                $video =new Video();
                $video->setUrl('https://youtu.be/rW3-b4qsFWs')
                 ->setFigure($figure);
                $em->persist($video);
                $figure->addVideo($video);
                }
    
                $em->persist($figure);    

        // nouvelle figure        
        $figure = new Figure();
        $figure->setName('grab') 
               ->setDescription('Consiste à attraper avec la main un bout du ski pendant le saut.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('grab_style')
                ->setUser($user);
                for($i=0; $i<5; $i++)
                {
                $image = new Image();
                 $image->setUrl('images/uploads')
                       ->setName('grab_sm.jpg') 
                       ->setFigure($figure);
    
                $em->persist($image);
                $figure->addImage($image);
                }
    
                for ($v=0; $v<mt_rand(1, 2); $v++)
                {
                $video =new Video();
                $video->setUrl('https://www.youtube.com/watch?v=z-gD3esFIm8')
                 ->setFigure($figure);
                $em->persist($video);
                $figure->addVideo($video);
                }
    
                $em->persist($figure);

        //new
        $figure = new Figure();
        $figure->setName('lipslide') 
               ->setDescription('ton tail passe par dessus le rail pour slider alors qu\'en normal,ton nose passe par dessus le rail.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('lipslide_style')
                ->setUser($user);
                for($i=0; $i<5; $i++)
                {
                $image = new Image();
                 $image->setUrl('images/uploads')
                       ->setName('lipslide_sm.jpg') 
                       ->setFigure($figure);
    
                $em->persist($image);
                $figure->addImage($image);
                }
    
                for ($v=0; $v<mt_rand(1, 2); $v++)
                {
                $video =new Video();
                $video->setUrl('https://youtu.be/rW3-b4qsFWs')
                 ->setFigure($figure);
                $em->persist($video);
                $figure->addVideo($video);
                }
    
                $em->persist($figure);


       
            // 9 comments
         for ($c=0; $c<9; $c++)   
         {
             $comment = new Comment();
             $comment->setContent($faker->sentence(rand(1,3)))
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setUser($user)
                    ->setFigure($figure);

            $em->persist($comment);
         }

        }



        $em->flush();
    }
}
