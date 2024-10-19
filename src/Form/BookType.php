<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Editor;
use App\Enum\BookStatus;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN'
            ])
            ->add('cover', TextType::class, [
                'label' => 'Couverture'
            ])
            ->add('editedAt', DateType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Date d\'édition',
                'widget' => 'single_text',
            ])
            ->add('plot', TextType::class, [
                'label' => 'Résumé'
            ])
            ->add('pageNumber', IntegerType::class, [
                'label' => 'Nombre de pages',
            ])
            ->add('status', EnumType::class, [
                'label' => 'Statut',
                'class' => BookStatus::class
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
                'by_reference' => false
            ])
            ->add('editor', EntityType::class, [
                'class' => Editor::class,
                'query_builder' => function(EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
