<?php

namespace AppBundle\Form;

use AppBundle\Subscriber\UserFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
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
/*            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.username.notblank'
                    ])
                ]
            ])*/
            /*->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.password.notblank'
                    ])
                ]
            ])*/
            ->add('civility',ChoiceType::class,[
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                    'Mademoiselle' => 'Mademoiselle',
                ]
])
            ->add('firstName')
            ->add('lastName')
            ->add('phoneMain')
            ->add('phoneSecond')
            ->add('phoneThird')
            ->add('fax')
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.password.notblank'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'user.email.notblank'
                    ]),
                    new Email([
                        'message' => 'user.email.message',
                        'checkHost' => true,
                        'checkMX' => true,

                    ])
                ]
            ])
            ->add('address', UserAdressType::class, [
                /*'data_class' => null,UserAdressType::class, /*permet de dire que c'est un formulaire imbriqué */
                'mapped' => null,  /*permet l'usage d'un formulaire imbriqué*/
            ])
            ->add('car', CarType::class, [
                /*'data_class' => null,CarType::class, /*permet de dire que c'est un formulaire imbriqué */
                'mapped' => null,  /*permet l'usage d'un formulaire imbriqué*/
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
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
