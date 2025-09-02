<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/employee')]
final class EmployeeController extends AbstractController
{
    #[Route(name: 'app_employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }
    
    #[Route('/api', name: 'api_employees', methods: ['GET'])]
    public function apiEmployees(EmployeeRepository $employeeRepository): JsonResponse
    {
        $employees = $employeeRepository->findAll();
        $data = [];

        foreach ($employees as $employee) {
            $data[] = [
                'id' => $employee->getId(),
                'name' => $employee->getName(),
                'email' => $employee->getEmail(),
                'courses' => implode(', ', array_map(fn($c) => $c->getName(), $employee->getCourses()->toArray())),
            ];
        }

        return $this->json(['data' => $data]);
    }

    #[Route('/new', name: 'app_employee_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_employee_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_employee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Employee $employee, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_employee_delete', methods: ['DELETE'])]
    public function delete(Request $request, Employee $employee, EntityManagerInterface $em): JsonResponse
    {

        try {
            $em->remove($employee);
            $em->flush();
            return $this->redirectToRoute('app_employee_index', [], Response::HTTP_SEE_OTHER);
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false], 400);
        }
    }

}
