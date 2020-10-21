<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\TopicsPeriod;
use App\Service\Date;
use App\Service\Validator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements OrderedFixtureInterface
{
    private $date;
    private $validator;

    public function __construct(Validator $validator, Date $date)
    {
        $this->date = $date;
        $this->validator = $validator;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            [
                'hour_start' => '13:50',
                'duration' => '1h45',
                'teacher' => 'AB59',
                'student' => [
                    'ENT85Z',
                ],
                'topics_period' => [
                    'topics' => 'anglais',
                    'period' => 'dimanche',
                ],
            ],
            [
                'hour_start' => '15:00',
                'duration' => '2h30',
                'teacher' => 'AI452',
                'student' => [
                    'ADT89',
                ],
                'topics_period' => [
                    'topics' => 'mathematiques',
                    'period' => 'lundi',
                ],
            ],
            [
                'hour_start' => '10:00',
                'duration' => '1h30',
                'teacher' => 'ABY56',
                'student' => [
                    'RTUI32',
                ],
                'topics_period' => [
                    'topics' => 'français',
                    'period' => 'Mardi',
                ],
            ],
            [
                'hour_start' => '12:00',
                'duration' => '2h30',
                'teacher' => 'AB20',
                'student' => [
                    'EXCT98',
                ],
                'topics_period' => [
                    'topics' => 'histoire',
                    'period' => 'Mercredi',
                ],
            ],
        ];

        foreach ($data as $value) {
            $course = new Course();
            $course->setHourStartAt($value['hour_start']);
            $course->setDuration($value['duration']);

            $topics_period_slug = $value['topics_period'];
            $topics = $topics_period_slug['topics'];
            $period = $topics_period_slug['period'];

            $teacher = $manager->getRepository(Teacher::class)->findOneByMatricule($value['teacher']);
            $topics_period = $manager->getRepository(TopicsPeriod::class)->getBySlug($topics, $period);

            $courseExist = $manager->getRepository(Course::class)->getByTopicsPeriod($topics, $period);

            if (isset($value['student'])) {
                $student_matricule = $value['student'];

                foreach ($student_matricule as $matricule) {
                    $student = $manager->getRepository(Student::class)->findOneByMatricule($matricule);

                    if ($student) {
                        $course->addStudent($student);
                    }
                }
            }

            if ($teacher) {
                $course->setTeacher($teacher);
            }

            if ($topics_period) {
                $course->setTopicsPeriod($topics_period);
            }

            if (!$courseExist && $this->validator->entity($course)) {
                $manager->persist($course);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
