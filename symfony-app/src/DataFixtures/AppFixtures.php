<?php

namespace App\DataFixtures;

use App\Entity\Member;
use App\Entity\Project;
use App\Entity\Vico;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $vico = $this->addVico($manager);
        $member = $this->addMember($manager);

        $this->addProject($vico, $member, $manager);
    }

    private function addVico(ObjectManager $manager): Vico
    {
        $vico = new Vico();
        $vico->setCreated(new \DateTime());
        $vico->setName('Vico');

        $manager->persist($vico);
        $manager->flush();

        return $vico;
    }

    private function addProject(
        Vico $vico,
        Member $member,
        ObjectManager $manager
    ): void {
        $projects = [
            'title' => 'project 1',
            'title' => 'project 2',
        ];

        foreach ($projects as $data) {
            $project = new Project();

            $project->setCreator($member);
            $project->setVico($vico);
            $project->setTitle($data);
            $project->setCreated(new \DateTime());

            $manager->persist($project);
        }
        $manager->flush();
    }

    private function addMember(ObjectManager $objectManager): Member
    {
        $member = new Member();
        $member->setUsername('member vico');

        $objectManager->persist($member);
        $objectManager->flush();

        return $member;
    }
}
