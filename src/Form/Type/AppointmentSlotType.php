<?php

namespace App\Form\Type;

use App\Entity\Slot;
use App\Entity\Teacher;
use App\Repository\AppointmentRepository;
use App\Repository\SlotRepository;
use App\Repository\TeacherRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentSlotType extends AbstractType
{

    private $tR;
    private $aR;
    private $sR;

    public function __construct(TeacherRepository $teacherRepository, AppointmentRepository $appointmentRepository, SlotRepository $slotRepository)
    {
        $this->tR = $teacherRepository;
        $this->aR = $appointmentRepository;
        $this->sR = $slotRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teacher', ChoiceType::class, [
                "choices" => $this->tR->findAll(),
                "choice_label" => function(?Teacher $t) {
                    return $t ? $t->__toString() : '';
                },
                "choice_value" => function(?Teacher $t) {
                    return $t ? $t->getId() : '';
                },
                "attr" => [
                    "id" => "teacherSel"
                ]
            ])
            ->add('slot', ChoiceType::class, [
                "choices" => $this->sR->findAll(),
                "choice_label" => function(?Slot $t) {
                    return $t ? $t->__toString() : '';
                },
                "choice_value" => function(?Slot $t) {
                    return $t ? $t->getId() : '';
                },
                "attr" => [
                    "id" => "slotSel"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
