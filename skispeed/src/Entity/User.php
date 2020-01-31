<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="La confirmation et le mot de passe ne sont pas identiques!")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resetToken;

    /**
     * @ORM\Column(type="boolean")
     */
    
    private $isLogged;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Figure", mappedBy="user", orphanRemoval=true)
     */
    private $figure;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->figure = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getconfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setconfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getIsLogged(): ?bool
    {
        return $this->isLogged;
    }

    public function setIsLogged(bool $isLogged): self
    {
        $this->isLogged = $isLogged;

        return $this;
    }

    public function __toString(){
        return $this->username;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt(){
    }

    public function eraseCredentials(){

    }





    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Figure[]
     */
    public function getFigure(): Collection
    {
        return $this->figure;
    }

    public function addFigure(Figure $figure): self
    {
        if (!$this->figure->contains($figure)) {
            $this->figure[] = $figure;
            $figure->setUser($this);
        }

        return $this;
    }

    public function removeFigure(Figure $figure): self
    {
        if ($this->figure->contains($figure)) {
            $this->figure->removeElement($figure);
            // set the owning side to null (unless already changed)
            if ($figure->getUser() === $this) {
                $figure->setUser(null);
            }
        }

        return $this;
    }

    public function getAvatarUrl(string $size = null): string
    {
        $url = 'https://randomuser.me/api/'.$this->getEmail();
        if ($size)
            $url .= sprintf('?size=%dx%d', $size, $size);
        return $url;
    }
}
