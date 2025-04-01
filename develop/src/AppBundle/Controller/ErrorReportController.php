<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ErrorReport;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ErrorReportController extends Controller
{
    /**
     * @Route("/error-report", name="app_error_report")
     * @Template(":ErrorReport:create.html.twig")
     * @param $request Request
     * @return RedirectResponse|array
     */
    public function createAction(Request $request)
    {
        $errorReport = new ErrorReport();
        if($request->isMethod('GET')) {
            $errorReport->setReferrer($request->headers->get('referer', ''));
        }
        $errorReport->setUser($this->getUser());
        $errorReport->setCategory($request->get('category', ErrorReport::CATEGORY_MISTYPE));

        $form = $this->createForm('error_report', $errorReport);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();

            $users = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User')->findUsersByReceivesErrorReportNotifications();

            $emailManager = $this->get('app.email_manager');

            $currentUser = $this->getUser();
            foreach ($users as $user) {
                if (!empty($currentUser) && $currentUser == $users) {
                    continue;
                }
                    $emailManager->sendErrorReport($errorReport, $user);
            }

            $this->addFlash('notice', 'Сообщение принято. Спасибо за внимание!');

            return $this->redirectToRoute('app_error_report');
        }

        return [
            'form' => $form->createView()
        ];
    }
}
