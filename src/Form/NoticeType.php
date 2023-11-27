<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Notice;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ]);

        if (in_array( 'ROLE_ADMIN', $options['user']->getRoles())){
            $builder->add('expiration', DateType::class, [
                'data' => new \DateTime("+2 weeks"),
                'constraints' => [
                    new NotBlank(),
                    new GreaterThan("today"),
                    new LessThan("+15 days")
                ]
            ]);
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
        $resolver->setRequired('user');
    }
}
