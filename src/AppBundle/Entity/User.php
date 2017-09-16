<?php
// src/AppBundle/Entity/User.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\EntityListeners({"AppBundle\Listener\UserListener"})
*/
class User implements UserInterface, \Serializable
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @var string
    *
    * @ORM\Column(type="string", length=60, unique=true)
    */
    private $email;

    /**
    * @ORM\Column(type="string", length=64)
    */
    private $password;

    /**
    * @ORM\Column(type="string", length=50, nullable=true)
    */
    private $username;

    /**
    * @ORM\Column(type="string", length=10)
    */
    private $civility;

    /**
    * @ORM\Column(type="string", length=50)
    */
    private $firstName;

    /**
    * @ORM\Column(type="string", length=50)
    */
    private $lastName;

    /**
    * @ORM\Column(type="integer", length=20)
    */
    private $phoneMain;

    /**
    * @ORM\Column(type="integer", length=20, nullable=true)
    */
    private $phoneSecond;

    /**
    * @ORM\Column(type="integer", length=20, nullable=true)
    */
    private $phoneThird;

    /**
    * @ORM\Column(type="integer", length=20, nullable=true)
    */
    private $fax;

    /**
    * @ORM\Column(type="datetime", length=20)
    */
    private $datetimeCreateAccount;

    /**
    * @ORM\Column(type="datetime", length=20, nullable=true)
    */
    private $datetimeLastRevision;

/*
 * *************   liaisons   *****************
 * */

    /**
    * @ORM\Column(name="is_active", type="boolean", options={"default" = 0})
    */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="UserAdress", mappedBy="user")
    */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="user")
    */
    private $cars;

    /**
     * @ORM\ManyToMany(targetEntity="Role")
     * @ORM\JoinTable(name="users_roles",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles;


/*
**********************  construct & method     ****************
* */

    public function __construct()
    {
    $this->isActive = true;
    // may not be needed, see section on salt below
    // $this->salt = md5(uniqid(null, true));
    }

    public function getUsername()
    {
    return $this->username;
    }

    public function getSalt()
    {
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
    }

    public function getPassword()
    {
    return $this->password;
    }

    public function getRoles()
    {
        /*Dois returner un tableau de nom de roles*/
        $results = [];
        foreach ($this->roles as $key => $value){
            $results[] = $value->getName();
        }
    return $results;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
    return serialize(array(
    $this->id,
    $this->username,
    $this->password,
    // see section on salt below
    // $this->salt,
    ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
    list (
    $this->id,
    $this->username,
    $this->password,
    // see section on salt below
    // $this->salt
    ) = unserialize($serialized);
    }

        /**
         * Get id
         *
         * @return integer
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Set username
         *
         * @param string $username
         *
         * @return User
         */
        public function setUsername($username)
        {
            $this->username = $username;

            return $this;
        }

        /**
         * Set password
         *
         * @param string $password
         *
         * @return User
         */
        public function setPassword($password)
        {
            $this->password = $password;

            return $this;
        }

        /**
         * Set email
         *
         * @param string $email
         *
         * @return User
         */
        public function setEmail($email)
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get email
         *
         * @return string
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set isActive
         *
         * @param boolean $isActive
         *
         * @return User
         */
        public function setIsActive($isActive)
        {
            $this->isActive = $isActive;

            return $this;
        }

        /**
         * Get isActive
         *
         * @return boolean
         */
        public function getIsActive()
        {
            return $this->isActive;
        }

        /**
         * Add role
         *
         * @param \AppBundle\Entity\Role $role
         *
         * @return User
         */
        public function addRole(\AppBundle\Entity\Role $role)
        {
            $this->roles[] = $role;

            return $this;
        }

        /**
         * Remove role
         *
         * @param \AppBundle\Entity\Role $role
         */
        public function removeRole(\AppBundle\Entity\Role $role)
        {
            $this->roles->removeElement($role);
        }

   

    /**
     * Add address
     *
     * @param \AppBundle\Entity\UserAdress $address
     *
     * @return User
     */
    public function addAddress(\AppBundle\Entity\UserAdress $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \AppBundle\Entity\UserAdress $address
     */
    public function removeAddress(\AppBundle\Entity\UserAdress $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phoneMain
     *
     * @param integer $phoneMain
     *
     * @return User
     */
    public function setPhoneMain($phoneMain)
    {
        $this->phoneMain = $phoneMain;

        return $this;
    }

    /**
     * Get phoneMain
     *
     * @return integer
     */
    public function getPhoneMain()
    {
        return $this->phoneMain;
    }

    /**
     * Set phoneSecond
     *
     * @param integer $phoneSecond
     *
     * @return User
     */
    public function setPhoneSecond($phoneSecond)
    {
        $this->phoneSecond = $phoneSecond;

        return $this;
    }

    /**
     * Get phoneSecond
     *
     * @return integer
     */
    public function getPhoneSecond()
    {
        return $this->phoneSecond;
    }

    /**
     * Set phoneThird
     *
     * @param integer $phoneThird
     *
     * @return User
     */
    public function setPhoneThird($phoneThird)
    {
        $this->phoneThird = $phoneThird;

        return $this;
    }

    /**
     * Get phoneThird
     *
     * @return integer
     */
    public function getPhoneThird()
    {
        return $this->phoneThird;
    }

    /**
     * Set fax
     *
     * @param integer $fax
     *
     * @return User
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return integer
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set datetimeCreateAccount
     *
     * @param \DateTime $datetimeCreateAccount
     *
     * @return User
     */
    public function setDatetimeCreateAccount($datetimeCreateAccount)
    {
        $this->datetimeCreateAccount = $datetimeCreateAccount;

        return $this;
    }

    /**
     * Get datetimeCreateAccount
     *
     * @return \DateTime
     */
    public function getDatetimeCreateAccount()
    {
        return $this->datetimeCreateAccount;
    }

    /**
     * Set datetimeLastRevision
     *
     * @param \DateTime $datetimeLastRevision
     *
     * @return User
     */
    public function setDatetimeLastRevision($datetimeLastRevision)
    {
        $this->datetimeLastRevision = $datetimeLastRevision;

        return $this;
    }

    /**
     * Get datetimeLastRevision
     *
     * @return \DateTime
     */
    public function getDatetimeLastRevision()
    {
        return $this->datetimeLastRevision;
    }

    /**
     * Add car
     *
     * @param \AppBundle\Entity\Car $car
     *
     * @return User
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
     * Set civility
     *
     * @param string $civility
     *
     * @return User
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }
}
