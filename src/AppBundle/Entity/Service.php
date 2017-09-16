<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(name="buyPrice", type="integer")
     */
    private $buyPrice;

    /**
     * @var int
     *
     * @ORM\Column(name="salePrice", type="integer")
     */
    private $salePrice;

    /**
     * @var int
     *
     * @ORM\Column(name="profitMargin", type="integer")
     */
    private $profitMargin;

    /**
     * Many Services have One ServiceCategory.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ServiceCategory", inversedBy="services")
     * @ORM\JoinColumn(name="service_category_id", referencedColumnName="id")
     */
    private $brand;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Service
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Service
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set buyPrice
     *
     * @param integer $buyPrice
     *
     * @return Service
     */
    public function setBuyPrice($buyPrice)
    {
        $this->buyPrice = $buyPrice;

        return $this;
    }

    /**
     * Get buyPrice
     *
     * @return int
     */
    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    /**
     * Set salePrice
     *
     * @param integer $salePrice
     *
     * @return Service
     */
    public function setSalePrice($salePrice)
    {
        $this->salePrice = $salePrice;

        return $this;
    }

    /**
     * Get salePrice
     *
     * @return int
     */
    public function getSalePrice()
    {
        return $this->salePrice;
    }

    /**
     * Set profitMargin
     *
     * @param integer $profitMargin
     *
     * @return Service
     */
    public function setProfitMargin($profitMargin)
    {
        $this->profitMargin = $profitMargin;

        return $this;
    }

    /**
     * Get profitMargin
     *
     * @return int
     */
    public function getProfitMargin()
    {
        return $this->profitMargin;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\ServiceCategory $brand
     *
     * @return Service
     */
    public function setBrand(\AppBundle\Entity\ServiceCategory $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\ServiceCategory
     */
    public function getBrand()
    {
        return $this->brand;
    }
}
