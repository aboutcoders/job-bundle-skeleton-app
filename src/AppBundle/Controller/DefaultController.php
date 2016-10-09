<?php

namespace AppBundle\Controller;

use Abc\Bundle\JobBundle\Entity\Schedule;
use Abc\Bundle\JobBundle\Job\Manager;
use Abc\Bundle\JobBundle\Job\ScheduleBuilder;
use Abc\Bundle\JobBundle\Model\JobManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/jobs", name="jobs")
     */
    public function indexJobAction(Request $request)
    {
        /** @var JobManagerInterface $manager */
        $manager = $this->get('abc.job.job_manager');

        // replace this example code with whatever you need
        return $this->render('default/jobs.html.twig', ['jobs' => $manager->findAll()]);
    }

    /**
     * @Route("/add/job", name="add_job")
     */
    public function addJobAction()
    {
        $number = mt_rand(0, 100);

        // retrieve job manager from the container
        /** @var Manager $manager */
        $manager = $this->get('abc.job.manager');

        // add job to the queue
        $job = $manager->addJob('say_hello', [$number]);


        $this->addFlash(
            'notice',
            'Job ' . $job->getTicket() . ' scheduled!'
        );

        return $this->redirectToRoute('jobs');

    }


    /**
     * @Route("/add/job-scheduled", name="add_job_scheduled")
     */
    public function addScheduledJobAction()
    {
        $number = mt_rand(0, 100);

        // retrieve job manager from the container
        /** @var Manager $manager */
        $manager = $this->get('abc.job.manager');

        // add job to the queue
        $schedule = ScheduleBuilder::create('cron', '5 * * * *');
        $job      = $manager->addJob('scheduled_hello', [$number], $schedule);


        $this->addFlash(
            'notice',
            'Job ' . $job->getTicket() . ' with schedule added!'
        );

        return $this->redirectToRoute('jobs');

    }

    /**
     * @Route("/job/{ticket}/log", name="get_job_log")
     */
    public function getJobLogAction($ticket)
    {
        // retrieve job manager from the container
        /** @var Manager $manager */
        $manager = $this->get('abc.job.manager');

        $logs = $manager->getLogs($ticket);

        return $this->render('default/logs.html.twig', ['logs' => $logs]);
    }
}
