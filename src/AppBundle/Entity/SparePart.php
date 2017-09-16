<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * SparePart
 *
 * @ORM\Table(name="spare_part")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SparePartRepository")
 */
class SparePart
{
    use Translatable;
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
     * @ORM\Column(name="price", type="decimal", precision=6, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, unique=true)
     */
    private $image;


    /**
     * @ORM\ManyToMany(targetEntity="Car", inversedBy="spareParts")
     * @ORM\JoinTable(name="spareparts_cars")
     */
    private $cars;

    /**
     * @ORM\ManyToOne(targetEntity="SparePartCategory")
     * @ORM\JoinColumn(name="spare_part_category_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $sparePartCategory;


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
     * Set price
     *
     * @param string $price
     *
     * @return SparePart
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cars = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add car
     *
     * @param \AppBundle\Entity\Car $car
     *
     * @return SparePart
     */
    public function addCar(\AppBundle\Entity\Car $car)
    {
        $this->cars[] = $car;

        return $this;
    }

    /**
     * Remove car
     *
     * @param \AppBundle\Entity\Car $car
     */
    public function removeCar(\AppBundle\Entity\Car $car)
    {
        $this->cars->removeElement($car);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * Set sparePartCategory
     *
     * @param \AppBundle\Entity\SparePartCategory $sparePartCategory
     *
     * @return SparePart
     */
    public function setSparePartCategory(\AppBundle\Entity\SparePartCategory $sparePartCategory = null)
    {
        $this->sparePartCategory = $sparePartCategory;

        return $this;
    }

    /**
     * Get sparePartCategory
     *
     * @return \AppBundle\Entity\SparePartCategory
     */
    public function getSparePartCategory()
    {
        return $this->sparePartCategory;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return SparePart
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}
