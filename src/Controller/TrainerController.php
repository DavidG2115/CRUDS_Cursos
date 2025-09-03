<?php

namespace App\Controller;

use App\Entity\Trainer;
use App\Form\TrainerType;
use App\Repository\TrainerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/trainer')]
final class TrainerController extends AbstractController
{
    #[Route(name: 'app_trainer_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $trainers = $entityManager
            ->getRepository(Trainer::class)
            ->findAll();

        return $this->render('trainer/index.html.twig', [
            'trainers' => $trainers,
        ]);
    }

    #[Route('/api', name: 'api_trainers', methods: ['GET'])]
    public function apiTrainers( TrainerRepository $repository ): JsonResponse
    {
        $trainers = $repository->findAll();
        $data = [];

        foreach ($trainers as $trainer) {
            $coursesName= [];
            foreach ($trainer->getCourses() as $course) {
                $coursesName[] = $course->getName();
            }

            $data[] = [
                'id' => $trainer->getId(),
                'name' => $trainer->getName(),
                'email' => $trainer->getEmail(),
                'course' => (implode(", ", $coursesName)),
            ];
        }

        return $this->json(['data' => $data]);

    }

    #[Route('/new', name: 'app_trainer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainer = new Trainer();
        $form = $this->createForm(TrainerType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainer);
            $entityManager->flush();

            return $this->redirectToRoute('app_trainer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trainer/new.html.twig', [
            'trainer' => $trainer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_trainer_show', methods: ['GET'])]
    public function show(Trainer $trainer): Response
    {
        return $this->render('trainer/show.html.twig', [
            'trainer' => $trainer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_trainer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trainer $trainer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainerType::class, $trainer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trainer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('trainer/edit.html.twig', [
            'trainer' => $trainer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_trainer_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, Trainer $trainer, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($trainer);
            $entityManager->flush();
            return $this->redirectToRoute('app_trainer_index', [], Response::HTTP_SEE_OTHER);

        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 400);
        }
    }
}
