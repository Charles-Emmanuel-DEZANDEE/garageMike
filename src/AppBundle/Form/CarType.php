<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
/*            ->add('user')*/
            ->add('mileage')
            ->add('registration')
            ->add('vehiculeIdentityNumber')
            ->add('brand', EntityType::class, [
                'class' => 'AppBundle\Entity\Brand',
                'choice_label' => 'name',
                'placeholder' => 'Selectionner',
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas selectionné de marque"
                    ])
                ]])
            ->add('model', EntityType::class, [
                'class' => 'AppBundle\Entity\Model',
                'choice_label' => 'name',
                'placeholder' => 'Selectionner',
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas selectionné de model"
                    ])
                ]])
            /*->add('model', ChoiceType::class,[
                'choices' => [

                ]
            ])*/

        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Car'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_car';
    }


}
