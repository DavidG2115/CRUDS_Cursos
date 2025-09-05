<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/course')]
final class CourseController extends AbstractController
{
    #[Route('/{_locale}', name: 'app_course_index', requirements: ['_locale' => 'en|es'], defaults: ['_locale' => 'en'], methods: ['GET'])]
    public function index(CourseRepository $courseRepository ): Response
    {
        
        return $this->render('course/index.html.twig', [
            'courses' => $courseRepository->findAll(),
        ]);
    }
    
    #[Route('/api', name: 'api_courses', methods: ['GET'])]
    public function apiCourses(CourseRepository $courseRepository ): JsonResponse
    {
        $courses = $courseRepository->findAll();
        $data = [];
        
        foreach ($courses as $course) {
            $employeeNames = [];
            foreach ($course->getEmployees() as $employee) {
                $employeeNames[] = $employee->getName();
            }
            
            // Obtener nombres de trainers (si aplica)
            $trainerNames = [];
            foreach ($course->getTrainers() as $trainer) {
                $trainerNames[] = $trainer->getName();
            }
            $data[] = [
                'id' => $course->getId(),
                'name' => $course->getName(),
                'description' => $course->getDescription(),
                'duration' => $course->getDuration(),
                'employees' => implode(', ', $employeeNames),
                'trainers' => implode(', ', $trainerNames),
                
            ];
        }
        
        return $this->json(['data' => $data]);
        
    }
    
    // #[Route('/new', name: 'app_course_new', methods: ['GET', 'POST'])]
    #[Route('/new/{_locale}', name: 'app_course_new', requirements: ['_locale' => 'en|es'], defaults: ['_locale' => 'en'], methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }
    
    // #[Route('/{id}', name: 'app_course_show', methods: ['GET'])]
    #[Route('/{id}/{_locale}', name: 'app_course_show', requirements: ['_locale' => 'en|es'], defaults: ['_locale' => 'en'], methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }
    
    // #[Route('/{id}/edit', name: 'app_course_edit', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit/{_locale}', name: 'app_course_edit', requirements: ['_locale' => 'en|es'], defaults: ['_locale' => 'en'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_course_delete', methods: ['DELETE', 'POST'])]
    public function delete(Request $request, Course $course, EntityManagerInterface $entityManager): Response
    {
        try {
            $entityManager->remove($course);
            $entityManager->flush();
            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);

        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 400);
        }

    }
}
