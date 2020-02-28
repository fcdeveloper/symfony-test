<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\IdProduct()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $idproduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $productname;

    public function getIdproduct(): ?int
    {
        return $this->idproduct;
    }

    public function setIdproduct(int $idproduct): self
    {
        $this->idproduct = $idproduct;

        return $this;
    }

    public function getProductname(): ?string
    {
        return $this->productname;
    }

    public function setProductname(?string $productname): self
    {
        $this->productname = $productname;

        return $this;
    }
}
