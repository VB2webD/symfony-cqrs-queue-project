<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestMessageFormType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount_prio1', IntegerType::class, [
                'label' => 'Amount of messages with Priority 1',
            ])
            ->add('amount_prio2', IntegerType::class, [
                'label' => 'Amount of messages with Priority 2',
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send with Priority '
            ]);
    }
}
