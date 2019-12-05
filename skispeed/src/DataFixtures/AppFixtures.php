<?php

namespace App\DataFixtures;


use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Figure;
use App\Entity\Comment;
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



    // figures
    for($i=0; $i<9; $i++)
    {
        $figure = new Figure();
        $figure->setName('bigair')
               ->setDescription('Il s\'agit d\'effectuer des figures dans les airs') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('bigair_style')
                ->setUser($user);
        $em->persist($figure);      

        $figure = new Figure();
        $figure->setName('flair')
               ->setDescription('Flip arrière avec une rotation latérale de 180°. Il s\'agit de sauter, tourner et atterrir.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('flair_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('grab') 
               ->setDescription('Consiste à attraper avec la main un bout du ski pendant le saut.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('grab_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('lipslide') 
               ->setDescription('ton tail passe par dessus le rail pour slider alors qu\'en normal,ton nose passe par dessus le rail.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('lipslide_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('liukang')
               ->setDescription('variante du safety dans laquelle la jambe dont le ski n\'est pas grabé est tendue. ') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('liukang_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('mute') 
               ->setDescription('saisie de ski à l\'avant de la fixation avec la main opposée au ski saisi.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('mute_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('philgrab') 
               ->setDescription('variante du safety dans laquelle les skis sont croisés au lieu d\'être parallèles.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('philgrab_style')
                ->setUser($user);
        $em->persist($figure);

        $figure = new Figure();
        $figure->setName('rotation360') 
               ->setDescription('Une fois que le tour complet est réalisé, le skieur devra affiner son impulsion et sa réception pour réaliser le 360 parfait.') 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug('360_style')
                ->setUser($user);
        $em->persist($figure);

        for ($i=0; $i<9; $i++)
        {
           $image = new Image();
           $image->setUrl('images/uploads')
               ->setFigure($figure);

        $em->persist($image);

         for ($c=0; $c<10; $c++)   
         {
             $comment = new Comment();
             $comment->setContent($faker->sentence(rand(1,3)))
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setUser($user)
                    ->setFigure($figure);

            $em->persist($comment);
         }

        }



    }

        $em->flush();
    }
}
