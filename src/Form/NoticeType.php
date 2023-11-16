<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Notice;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $forUserDays = 8;
        $forSuperUserDays = 15;

//        if($options['user']->hasRole('ROLE_ADMIN')===true OR $options['user']->hasRole('ROLE_SUPER_USER')===true){
//            $days = $forSuperUserDays;
//            $defaultWeeks = 2;
//        } elseif ($options['user']->hasRole('ROLE_USER')===true) {
//            $days = $forUserDays;
//            $defaultWeeks = 1;
//        }

        $builder
            ->add('title')
            ->add('description')
            ->add('image', FileType::class, [
                'label' => 'Picture (jpg file)',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5000k',
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Add picture in .jpg or .jpeg format'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'placeholder' => 'Choose Notice Category',
                'class' => Category::class,
                'query_builder' => function (CategoryRepository $er){
                    return $er->createQueryBuilder('c')->orderBy('c.categoryName', 'ASC');
                },
                'choice_label' => 'category_name',
            ])
//            ->add('expiration')
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
