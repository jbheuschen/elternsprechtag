<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Teacher;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @Route("/appointment")
 */
class AppointmentController extends AbstractController
{
    /**
     * @Route("/", name="appointment_index", methods={"GET"})
     */
    public function index(AppointmentRepository $appointmentRepository): Response
    {
        return $this->render('appointment/index.html.twig', [
            'appointments' => $appointmentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/blocked/{id}", name="blocked_slots", methods={"GET"})
     */
    public function blocked(Teacher $teacher, AppointmentRepository $appointmentRepository): Response
    {
        $apps = $appointmentRepository->findBy(["teacher" => $teacher]);
        return new JsonResponse(array_map(function($a) {
            return $a->getSlot()->getId();
        }, $apps));
    }

    /**
     * @Route("/new", name="appointment_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $appointment = new Appointment();
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($appointment);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->to($appointment->getEmail())
                ->subject('Ihr Elternsprechstagstermin')
                ->htmlTemplate('mail/success.html.twig')
                ->context([
                    "appointment" => $appointment,
                ]);
            $mailer->send($email);

            return $this->redirectToRoute('appointment_index');
        }



        return $this->render('appointment/new.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cancel/{id}", name="appointment_cancel", methods={"GET","POST"})
     */
    public function cancel(Appointment $appointment, Request $request, MailerInterface $mailer): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * @Route("/{id}", name="appointment_show", methods={"GET"})
     */
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appointment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Appointment $appointment): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('appointment_index');
        }

        return $this->render('appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="appointment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Appointment $appointment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('appointment_index');
    }
}
