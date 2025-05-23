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
            ->add('server', ChoiceType::class, [
                'label' => 'Serveur',
                'choices' => [
                    'Archimonde' => 'Archimonde',
                    'Ysondre' => 'Ysondre',
                    'Dalaran' => 'Dalaran',
                    'Hyjal' => 'Hyjal',
                    'Elune' => 'Elune',
                    'Sargeras' => 'Sargeras',
                    'Garona' => 'Garona',
                    'Rashgarroth' => 'Rashgarroth',
                    'Arak-arahm' => 'Arak-arahm',
                    'Sinstralis' => 'Sinstralis',
                    'Culte de la Rive noire' => 'Culte de la Rive noire',
                    'Varimathras' => 'Varimathras',
                    'Kirin Tor' => 'Kirin Tor',
                    'Medivh' => 'Medivh',
                    'Illidan' => 'Illidan',
                    'Suramar' => 'Suramar',
                    'Uldaman' => 'Uldaman',
                    'Eitrigg' => 'Eitrigg',
                ],
                'placeholder' => 'Choisir un serveur',
            ])

            ->add('classe', EntityType::class, [
                'class' => Classe::class,
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
