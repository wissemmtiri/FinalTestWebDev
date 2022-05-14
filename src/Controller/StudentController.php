<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class StudentController extends AbstractController
{
    #[Route('/edit/{id<\d+>}', name: 'Edit_Student')]
    public function edit(Student $student=null, ManagerRegistry $doctrine, Request $request): Response{
        if (!$student){
            $student = new Student();
        }
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $manager = $doctrine->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('success', 'Student updated successfully!');
            return $this->redirectToRoute('Students_List');
        }
        return $this->render('/student/add.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/add', name: 'Add_Student')]
    public function add(ManagerRegistry $doctrine, Request $request): Response{
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $manager = $doctrine->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('success', 'Student added successfully!');
            return $this->redirectToRoute('Students_List');
        }
        return $this->render('/student/add.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/delete/{id<\d+>}', name: 'Delete_Student')]
    public function delete(ManagerRegistry $doctrine, Student $student=null):Response{
        if(!$student){
            $this->addFlash('error','Student Not Found!');
        }else{
            $manager = $doctrine->getManager();
            $manager->remove($student);
            $manager->flush();
            $this->addFlash('success','Student deleted Successfully!');
        }
        return $this->redirectToRoute('Students_List');
    }

    #[Route('/details/{id<\d+>}', name: 'Student_Details')]
    public function details(ManagerRegistry $doctrine,$id):Response{
        $repository = $doctrine->getRepository(Student::class);
        $student = $repository->find($id);
        if(!$student){
            $this->addFlash('error','Student not found');
            return $this->redirectToRoute('Students_List');
        }
        return $this->render('/student/details.html.twig',['student'=>$student]);
    }

    #[Route('/', name: 'Students_List')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Student::class);
        $students = $repository->findAll();
        return $this->render('student/index.html.twig', [
            'students'=>$students
        ]);
    }
}
