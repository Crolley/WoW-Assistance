<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Classe;
use App\Entity\Guild;
use App\Entity\Specialisation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class CharacterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameCharacter')
            ->add('raiderIo')
            ->add('server')
            ->add('role', ChoiceType::class, [
                'choices' => array_flip(Character::ROLES),
            ])

            ->add('classe', EntityType::class, [
                'class' => Classe::class,
                'choice_label' => 'name',
            ])
            ->add('guild', EntityType::class, [
                'class' => Guild::class,
                'choice_label' => 'name',
            ])
            ->add('specialisation', EntityType::class, [
                'class' => Specialisation::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
