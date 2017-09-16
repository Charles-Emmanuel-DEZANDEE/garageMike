<?php

namespace AppBundle\Form;

use AppBundle\Subscriber\UserFormSubscriber;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserAdressType extends AbstractType
{
    private $request;
    private $passwordEncoderService;

    /**
     * UserFormSubscriber constructor.
     * @param $request
     */
    public function __construct(RequestStack $request,UserPasswordEncoder $passwordEncoder)
    {
        $this->request = $request;
        $this->passwordEncoderService = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'userAdress.name.notblank'
                    ])
                ]
            ])
            ->add('main', ChoiceType::class,[
                'choices' =>[
                    'yes' => true,
                    'no' => false,
                ]
            ])
            ->add('numberStreet', IntegerType::class)
            ->add('street1', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'userAdress.name.notblank'
                    ])
                ]
            ])
            ->add('street2', TextType::class)
            ->add('zipCode', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'userAdress.zipCode.notblank'
                    ])
                ]
            ])
            ->add('city', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'userAdress.city.notblank'
                    ])
                ]
            ])
            ->add('state', TextType::class)
            ->add('country', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'userAdress.country.notblank'
                    ])
                ]/*,
                'preferred_choices' => ['FR'],*/
            ])
        ;
        // activation du souscripteur
        $builder->addEventSubscriber(new UserFormSubscriber($this->request, $this->passwordEncoderService));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserAdress'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_useradress';
    }


}
