<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServiceOrder
 *
 * @ORM\Table(name="service_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceOrderRepository")
 */
class ServiceOrder
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
     * @ORM\Column(name="orderNumber", type="string", length=50, unique=true)
     */
    private $orderNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetimeCreate", type="datetime")
     */
    private $datetimeCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetimeLastUpdate", type="datetime", nullable=true)
     */
    private $datetimeLastUpdate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isConfirm", type="boolean")
     */
    private $isConfirm;

    /**
     * @var int
     *
     * @ORM\Column(name="taxAmount", type="integer")
     */
    private $taxAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="discountAmount", type="integer", nullable=true)
     */
    private $discountAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="discountRate", type="integer", nullable=true)
     */
    private $discountRate;

    /**
     * @var int
     *
     * @ORM\Column(name="totalAmount", type="integer")
     */
    private $totalAmount;


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
     * Set orderNumber
     *
     * @param string $orderNumber
     *
     * @return ServiceOrder
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set datetimeCreate
     *
     * @param \DateTime $datetimeCreate
     *
     * @return ServiceOrder
     */
    public function setDatetimeCreate($datetimeCreate)
    {
        $this->datetimeCreate = $datetimeCreate;

        return $this;
    }

    /**
     * Get datetimeCreate
     *
     * @return \DateTime
     */
    public function getDatetimeCreate()
    {
        return $this->datetimeCreate;
    }

    /**
     * Set datetimeLastUpdate
     *
     * @param \DateTime $datetimeLastUpdate
     *
     * @return ServiceOrder
     */
    public function setDatetimeLastUpdate($datetimeLastUpdate)
    {
        $this->datetimeLastUpdate = $datetimeLastUpdate;

        return $this;
    }

    /**
     * Get datetimeLastUpdate
     *
     * @return \DateTime
     */
    public function getDatetimeLastUpdate()
    {
        return $this->datetimeLastUpdate;
    }

    /**
     * Set isConfirm
     *
     * @param boolean $isConfirm
     *
     * @return ServiceOrder
     */
    public function setIsConfirm($isConfirm)
    {
        $this->isConfirm = $isConfirm;

        return $this;
    }

    /**
     * Get isConfirm
     *
     * @return bool
     */
    public function getIsConfirm()
    {
        return $this->isConfirm;
    }

    /**
     * Set taxAmount
     *
     * @param integer $taxAmount
     *
     * @return ServiceOrder
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount
     *
     * @return int
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Set discountAmount
     *
     * @param integer $discountAmount
     *
     * @return ServiceOrder
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;

        return $this;
    }

    /**
     * Get discountAmount
     *
     * @return int
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * Set discountRate
     *
     * @param integer $discountRate
     *
     * @return ServiceOrder
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;

        return $this;
    }

    /**
     * Get discountRate
     *
     * @return int
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     *
     * @return ServiceOrder
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }
}

