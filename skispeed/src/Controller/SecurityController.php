<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Form\ResetPasswordType;
use App\Form\ForgotPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{

     /**
     * @Route("/register", name="security_register")
     */
    public function registerAction(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $password= $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password)
                ->setCreatedAt(new \DateTime)
                ->setResetToken(md5(random_bytes(10)))
                ->setIsLogged(true);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre compte a bien été enregistré!');

            return $this->redirectToRoute('security_login');

        }
        return $this->render('security/register.html.twig',
        ['form' => $form->createView()
        ]);
    }

    /**
     * @Route("/security/reset-password/{token}", name="security_reset_password")
     */

     public function resetPassword(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, string $token)
     {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneByResetToken($token);
        
        $form =$this->createForm(ResetPasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if($user->getToken() === $token)
            {
                $password = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'votre mot de pass a bien été modifié!');
            }
            return $this->redirectToRoute('security_login');
        }
        else {
            if($user === null) {
                $this->addFlash('danger', 'Echec de modification du mot de passe! Lien introuvable.');
            }
        }
        return $this->render('security/resetPassword.html.twig', 
        ['form' => $form->createView(),
        'token' => $token
        ]); 
    }


    /**
      * @Route("/security/forgot-password", name="security_forgot_password")
      */
      public function forgotPassword(Request $request, EntityManagerInterface $em, TokenGeneratorInterface $tokengenerator, \Swift_Mailer $mailer)
      {
          $form = $this->createForm(ForgotPasswordType::class);
          $form->handleRequest($request);
          
          if($form->isSubmitted() && $form->isValid())
          {
            $email = $form->getData('email');

            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($email);

            if($user === null)
            {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('security_forgot_password');
            }
            
              $token = $tokenGenerator->generateToken();

              try{
              $user->setResetToken($token);
              $em->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('security_forgot_password');
            }

                $url = $this->generateUrl('security_reset_password', ['token'=> $token],
            UrlGeneratorInterface::ABSOLUTE_URL
            );

              $message =  (new \Swift_Message('Réinitialisation du mot de passe'))
              ->setFrom($this->getParameter('mailer_user'))
              ->setTo($user->getEmail())
              ->setBody(
                  $this->renderView('security/forgotPassword.html.twig', [
                      'user' => $user
                  ]),
                  'text/html'
                  );

                  $mailer->send($message);
                  $this->addFlash(
                      'success',
                      "Nous vous avons envoyé un email de réinitialisation à l'adresse email enregistrée pour le compte !"
                  );

                  return $this->redirectToRoute('security_password_forgot');
            }

          return $this->render('security/forgotPassword.html.twig',
          [
              'form' => $form->createView()
          ]);
      }  
      
    /**
     * @Route("/login", name="security_login")
     * @param  AuthenticationUtils $authenticationUtils
     */
    public function login(Request $request, AuthenticationUtils $utils)
  
    {
       $error = $utils->getLastAuthenticationError();
       $lastUsername = $utils->getLastUsername();

       $form = $this->createForm(LoginType::class);

        return $this->render('security/login.html.twig', 
        ['form' => $form->createView(),
        'last_username' => $lastUsername,
        'error'         => $error,
         ]);
    }

    /**
     * @Route("/profile", name="security_profil")
     */
    public function profile()
    {
        return $this->render('security/profile.html.twig');
    }


    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {}
}