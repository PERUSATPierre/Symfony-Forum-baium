<?php
    namespace BlogBundle\Form;

    use BlogBundle\Entity\News;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\FormType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    class NewsType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $option)
        {
            $builder
            ->add('title', TextType::class)
            ->add('content',TextareaType::class, array('attr'=> array('cols'=>70, 'rows'=>20)))
            ->add('image', FileType::class, array('data_class'=>null))
            ->add('envoyer', SubmitType::class);
        }
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => News::class,
            ));
        }
    }