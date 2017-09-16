<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Sluggable\Sluggable;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;

/**
 * SparePart
 *
 * @ORM\Table(name="spare_part_translation")
 * @ORM\Entity()
 */
class SparePartTranslation

{
    use Sluggable, Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;



    /**
     * Set name
     *
     * @param string $name
     *
     * @return SparePart
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


    //sluggable behavior : fait le slug automatique
    public function getSluggableFields()
    {
        return ["name"];
    }
}
