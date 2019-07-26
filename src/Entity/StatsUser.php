<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepositoryInterface\StatsUserRepository")
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $blocked = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $attempt;

    /**
     * Le nombre de tentative de connection avant
     * que le compte soit bloqué pendant un certain temps
     */
    const NB_ATTEMPT_AUTH = 5;

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

    public function getBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): self
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getAttempt(): ?int
    {
        return $this->attempt;
    }

    public function setAttempt(?int $attempt): self
    {
        $this->attempt = $attempt;

        return $this;
    }
}
