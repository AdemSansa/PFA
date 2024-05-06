<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Categories;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('ISBN')
            ->add('slug')
            ->add('image')
            ->add('resume')
            ->add('editeur')
            ->add('EditedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('prix')
            ->add('qte')
            ->add('auteur')
            ->add('Categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'libelle',
            ])       
            ->add('enregistrer',SubmitType::class);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
