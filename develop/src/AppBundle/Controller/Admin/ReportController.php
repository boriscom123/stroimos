<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ReportController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        try {
            $start = $request->query->get('start');
            if (!$start) {
                $start = new \DateTime('now');
                $start->modify('-1 month');
                $start = $start->format('Y-m-d');
            }
            $end = $request->query->get('end');
            if (!$end) {
                $end = (new \DateTime('now'))->format('Y-m-d');
            }
        } catch (\Exception $e) {
            throw $this->createNotFoundException();
        }

        $reports = $this->get('app.report_builder')->getReports();
        $now = (new \DateTime());
        $daysFromYearStart = (new \DateTime('first day of January '.$now->format('Y')))->diff($now)->days;

        $parameters = [
            'admin_pool' => $this->get('sonata.admin.pool'),
            'reports' => $reports,
            'start' => $start.' 00:00:00',
            'start_widget' => $start,
            'end' => $end.' 23:59:59',
            'end_widget' => $end,
            'days_from_year_start' => $daysFromYearStart,
        ];

        return $this->render(':Admin/Report:publications.html.twig', $parameters);
    }

    public function reportByContentAction(Request $request)
    {
        $parameters = [
            'admin_pool' => $this->get('sonata.admin.pool'),
        ];

        return $this->render(':Admin/Report:reportByContent.html.twig', $parameters);
    }
}
