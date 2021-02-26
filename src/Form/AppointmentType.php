<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ["attr" => ["placeholder" => "Vorname"]])
            ->add('surname', null, ["attr" => ["placeholder" => "Name"]])
            ->add('email', EMailType::class, ["attr" => ["placeholder" => "E-Mail-Adresse"]])
            ->add('message', TextAreaType::class, ["attr" => ["placeholder" => "Nachricht (optional)"]])
            ->add('slot')
            ->add('teacher')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
