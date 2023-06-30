<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Articulo::class, orphanRemoval: true)]
    private Collection $articulos;

    public function __construct()
    {
        $this->articulos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Articulo>
     */
    public function getArticulos(): Collection
    {
        return $this->articulos;
    }

    public function addArticulo(Articulo $articulo): static
    {
        if (!$this->articulos->contains($articulo)) {
            $this->articulos->add($articulo);
            $articulo->setUsuario($this);
        }

        return $this;
    }

    public function removeArticulo(Articulo $articulo): static
    {
        if ($this->articulos->removeElement($articulo)) {
            // set the owning side to null (unless already changed)
            if ($articulo->getUsuario() === $this) {
                $articulo->setUsuario(null);
            }
        }

        return $this;
    }
}