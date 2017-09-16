<?php

namespace AppBundle\Form;

use AppBundle\Entity\SparePartCategoryTranslation;
use AppBundle\Subscriber\SparePartCategoryFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SparePartCategoryType extends AbstractType
{
    private $locales;

    /**
     * SparePartCategoryType constructor.
     * @param $locales
     */
    public function __construct($locales)
    {
        $this->locales = $locales;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', SparePartCategoryTranslationType::class, [
                'data_class' => null
            ])
            ->add('isActive', ChoiceType::class, [
                'choices' => [
                    'yes' => true,
                    'no' => false
                ]
            ]);
        // activation souscripteur
        $builder->addEventSubscriber(new SparePartCategoryFormSubscriber($this->locales));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SparePartCategory'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sparepartcategory';
    }


}
