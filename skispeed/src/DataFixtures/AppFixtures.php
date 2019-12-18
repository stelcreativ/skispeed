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
    const FIGURE_REFERENCE = 'Figures';

    public function load(ObjectManager $em)
    {
    $faker = \Faker\Factory::create('fr_FR');
    
    $figureList = [
                    ['bigair',
                    ' Il s\'agit d\'un tremplin permettant d\'effectuer des figures dans les airs.'],
                    ['flair',
                    'Flip arrière avec une rotation latérale de 180°. Il s\'agit de sauter, tourner et atterrir.'],
                    ['grab',
                    'Consiste à attraper avec la main un bout du ski pendant le saut.'],
                    ['lipslide',
                    'ton tail passe par dessus le rail pour slider alors qu\'en normal,ton nose passe par dessus le rail.'],
                    ['liukang',
                    'variante du safety dans laquelle la jambe dont le ski n\'est pas grabé est tendue. '],
                    ['mute',
                    'saisie de ski à l\'avant de la fixation avec la main opposée au ski saisi.'],
                    ['philgrab',
                    'variante du safety dans laquelle les skis sont croisés au lieu d\'être parallèles.'],
                    ['rotation360',
                    'Une fois que le tour complet est réalisé, le skieur devra affiner son impulsion et sa réception pour réaliser le 360 parfait.']
        ];
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
    $i=1;
    foreach($figureList as list($name, $description))
    {
        $figure = new Figure();
        $figure->setName($name)
               ->setDescription($description) 
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setSlug($name. '_style')
                ->setUser($user);
                
                for($i=1; $i<4; $i++)
            {
            $image = new Image();
             $image->setUrl('images/uploads')
                   ->setName($name . '_sm' . $i . '.jpg') 
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
        
            $this->setReference(self::FIGURE_REFERENCE . $i, $figure);
            $i++;

       
            // 8 commentaires
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
