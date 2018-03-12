<?php
namespace ForumBundle\Form;

use ForumBundle\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
        ->add('message', TextareaType::class, array('attr'=>array('cols'=>70, 'rows'=>20)))
        ->add('poster', SubmitType::class);
    }
    public function configureOption(OptionResolver $resolver)
    {
        $resolver->setDefaults(array('data_class'=>Forum::class));
    }
}