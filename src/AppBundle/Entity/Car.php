<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;

/**
 * Car
 *
 * @ORM\Table(name="car")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
{
    use Sluggable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="mileage", type="integer")
     */
    private $mileage;

    /**
     * @var string
     *
     * @ORM\Column(name="registration", type="string", length=50)
     */
    private $registration;

    /**
     * @var string
     *
     * @ORM\Column(name="vehicule_identity_number", type="string", length=50)
     */
    private $vehiculeIdentityNumber;



    /**
     * Many Cars have One Brand.
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="cars")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;


    /**
     * Many cars have One Model.
     * @ORM\ManyToOne(targetEntity="Model", inversedBy="cars")
     * @ORM\JoinColumn(name="model", referencedColumnName="id")
     */
    private $model;

    /*
     * @ORM\ManyToMany(targetEntity="SparePart", mappedBy="cars")
    private $spareParts;
     */

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="cars")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;



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
     * Set model
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    //sluggable behavior : fait le slug automatique
    public function getSluggableFields()
    {
        return ["model"];
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->spareParts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     *
     * @return Car
     */
    public function setBrand(\AppBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add sparePart
     *
     * @param \AppBundle\Entity\SparePart $sparePart
     *
     * @return Car
     */
    public function addSparePart(\AppBundle\Entity\SparePart $sparePart)
    {
        $this->spareParts[] = $sparePart;

        return $this;
    }

    /**
     * Remove sparePart
     *
     * @param \AppBundle\Entity\SparePart $sparePart
     */
    public function removeSparePart(\AppBundle\Entity\SparePart $sparePart)
    {
        $this->spareParts->removeElement($sparePart);
    }

    /**
     * Get spareParts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSpareParts()
    {
        return $this->spareParts;
    }



    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Car
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Car
     */
    public function addModel(\AppBundle\Entity\Model $model)
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(\AppBundle\Entity\Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Model $product
     *
     * @return Car
     */
    public function setProduct(\AppBundle\Entity\Model $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Model
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set mileage
     *
     * @param integer $mileage
     *
     * @return Car
     */
    public function setMileage($mileage)
    {
        $this->mileage = $mileage;

        return $this;
    }

    /**
     * Get mileage
     *
     * @return integer
     */
    public function getMileage()
    {
        return $this->mileage;
    }

    /**
     * Set registration
     *
     * @param string $registration
     *
     * @return Car
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return string
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set vehiculeIdentityNumber
     *
     * @param string $vehiculeIdentityNumber
     *
     * @return Car
     */
    public function setVehiculeIdentityNumber($vehiculeIdentityNumber)
    {
        $this->vehiculeIdentityNumber = $vehiculeIdentityNumber;

        return $this;
    }

    /**
     * Get vehiculeIdentityNumber
     *
     * @return string
     */
    public function getVehiculeIdentityNumber()
    {
        return $this->vehiculeIdentityNumber;
    }
}
