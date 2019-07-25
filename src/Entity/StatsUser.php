<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatsUserRepository")
 */
class StatsUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="statsUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbConnection;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectionAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbUpdateProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbConnection(): ?int
    {
        return $this->nbConnection;
    }

    public function setNbConnection(?int $nbConnection): self
    {
        $this->nbConnection = $nbConnection;

        return $this;
    }

    public function getLastConnectionAt(): ?\DateTimeInterface
    {
        return $this->lastConnectionAt;
    }

    public function setLastConnectionAt(?\DateTimeInterface $lastConnectionAt): self
    {
        $this->lastConnectionAt = $lastConnectionAt;

        return $this;
    }

    public function getNbUpdateProfile(): ?int
    {
        return $this->nbUpdateProfile;
    }

    public function setNbUpdateProfile(?int $nbUpdateProfile): self
    {
        $this->nbUpdateProfile = $nbUpdateProfile;

        return $this;
    }
}
