<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Personne;
use App\Entity\Profil;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('age')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('profile', EntityType::class, [  // voir options dans la doc (form types reference)
                'expanded' => true,
                'class' => Profil::class,           // boutons radio
                'multiple' => false
            ])
            ->add('hobbies', EntityType::class, [
                'expanded' => false,
                'class' => Hobby::class,           
                'multiple' => true,
                'query_builder' => function (EntityRepository $er) {  // voir doc
                    return $er->createQueryBuilder(alias: 'h')
                    ->orderBy( sort: 'h.designation', order: 'ASC');
                }

            ])
            ->add('job')
            ->add('ajouter', type:SubmitType::class)  // ajoute bouton submit en bas du form dans vue
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
