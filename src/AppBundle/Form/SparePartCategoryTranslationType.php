<?php

namespace AppBundle\Form;

use AppBundle\Entity\SparePartCategory;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SparePartCategoryTranslationType extends AbstractType
{
    private $locales;
    private $request;
    private $doctrine;

    /**
     * SparePartCategoryTranslationType constructor.
     * @param $locales
     */
    public function __construct($locales, RequestStack $request, ManagerRegistry $doctrine)
    {
        $this->locales = $locales;
        $this->request = $request->getMasterRequest();
        $this->doctrine = $doctrine;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // récupération de l'id dans l'url
        $entityId = !empty($this->request->get('id')) ? $this->request->get('id') : null;

        // requetes
        $results = $entityId ? $this->doctrine->getRepository(SparePartCategory::class)->find($entityId) : null;

        // data remplir les champs
        foreach ($this->locales as $key => $value){


            $builder->add("name_$value", TextType::class,[
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message'=> "erreur $value > name"
                    ])
                ],
                'data' => $results ? $results->translate($value)->getName() : null
            ]);

        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\SparePartCategoryTranslation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_sparepartcategorytranslation';
    }


}
