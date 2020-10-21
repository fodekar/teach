<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Topics;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $course = $this->getRepositoryCourse()->findAll();

        $course = array_chunk($course, 2);

        //dump(
        //['course' => $course, 'topics period of course' => $course[0]->getTopicsPeriod()->getTopics()->getName()],
        //'Course'
        //);
        //dump($this->getRepositoryTopics()->findAll(), 'Topics');
        dump($course);

        return $this->render('home/index.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        $course = $this->getRepositoryCourse()->findAll();

        $course = array_chunk($course, 2);

        //dump(
        //['course' => $course, 'topics period of course' => $course[0]->getTopicsPeriod()->getTopics()->getName()],
        //'Course'
        //);
        //dump($this->getRepositoryTopics()->findAll(), 'Topics');
        dump($course);

        return $this->render('home/dashboard.html.twig', [
            'course' => $course,
        ]);
    }

    private function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    private function getRepositoryTopics()
    {
        return $this->getManager()->getRepository(Topics::class);
    }

    private function getRepositoryCourse()
    {
        return $this->getManager()->getRepository(Course::class);
    }
}
