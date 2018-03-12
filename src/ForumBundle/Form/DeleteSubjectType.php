<?php

use ForumBundle\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class DeleteSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
        ->setMethod('DELETE')
        ->remove('content');
    }
    public function getParent()
    {
        return AddSubjectType::class;
    }
}
