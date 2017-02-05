<?php

namespace AppBundle\Form;

use AppBundle\Entity\AbstractEntry;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['show_entry']) {
			$builder
				->add('entry', EntityType::class, array(
					'required' => true,
					'class' => AbstractEntry::class
				));
		}

		$builder
			->add('title')
			->add('content')
            ->add('email', EmailType::class)
            ->add('author', EntityType::class, array(
                'required' => true,
                'class' => Author::class
            ))
            ->add('submit', SubmitType::class)
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Comment::class,
			'show_entry' => true
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_comment';
    }


}
