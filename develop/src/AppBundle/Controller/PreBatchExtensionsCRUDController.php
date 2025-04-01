<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Admin\Extension\HomepageGuardExtension;
use AppBundle\Admin\Extension\MenuGuardExtension;
use Sonata\AdminBundle\Admin\BaseFieldDescription;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;

trait PreBatchExtensionsCRUDController
{
    public function batchAction()
    {
        $restMethod = $this->getRestMethod();

        if ('POST' !== $restMethod) {
            throw $this->createNotFoundException(sprintf('Invalid request type "%s", POST expected', $restMethod));
        }

        // check the csrf token
        $this->validateCsrfToken('sonata.batch');

        $confirmation = $this->get('request')->get('confirmation', false);

        if ($data = json_decode($this->get('request')->get('data'), true)) {
            $action       = $data['action'];
            $idx          = $data['idx'];
            $allElements  = $data['all_elements'];
            $this->get('request')->request->replace($data);
        } else {
            $this->get('request')->request->set('idx', $this->get('request')->get('idx', array()));
            $this->get('request')->request->set('all_elements', $this->get('request')->get('all_elements', false));

            $action       = $this->get('request')->get('action');
            $idx          = $this->get('request')->get('idx');
            $allElements  = $this->get('request')->get('all_elements');
            $data         = $this->get('request')->request->all();

            unset($data['_sonata_csrf_token']);
        }

        $batchActions = $this->admin->getBatchActions();
        if (!array_key_exists($action, $batchActions)) {
            throw new \RuntimeException(sprintf('The `%s` batch action is not defined', $action));
        }

        $camelizedAction = BaseFieldDescription::camelize($action);
        $isRelevantAction = sprintf('batchAction%sIsRelevant', ucfirst($camelizedAction));

        if (method_exists($this, $isRelevantAction)) {
            $nonRelevantMessage = call_user_func(array($this, $isRelevantAction), $idx, $allElements);
        } else {
            $nonRelevantMessage = count($idx) != 0 || $allElements; // at least one item is selected
        }

        if (!$nonRelevantMessage) { // default non relevant message (if false of null)
            $nonRelevantMessage = 'flash_batch_empty';
        }

        $datagrid = $this->admin->getDatagrid();
        $datagrid->buildPager();

        if (true !== $nonRelevantMessage) {
            $this->addFlash('sonata_flash_info', $nonRelevantMessage);

            return new RedirectResponse(
                $this->admin->generateUrl(
                    'list',
                    array('filter' => $this->admin->getFilterParameters())
                )
            );
        }

        $askConfirmation = isset($batchActions[$action]['ask_confirmation']) ?
            $batchActions[$action]['ask_confirmation'] :
            true;

        if ($askConfirmation && $confirmation != 'ok') {
            $actionLabel = $batchActions[$action]['label'];

            $formView = $datagrid->getForm()->createView();

            return $this->render($this->admin->getTemplate('batch_confirmation'), array(
                'action'     => 'list',
                'action_label' => $actionLabel,
                'datagrid'   => $datagrid,
                'form'       => $formView,
                'data'       => $data,
                'csrf_token' => $this->getCsrfToken('sonata.batch'),
            ));
        }

        // execute the action, batchActionXxxxx
        $finalAction = sprintf('batchAction%s', ucfirst($camelizedAction));
        if (!method_exists($this, $finalAction)) {
            throw new \RuntimeException(sprintf('A `%s::%s` method must be created', get_class($this), $finalAction));
        }

        $query = $datagrid->getQuery();

        $query->setFirstResult(null);
        $query->setMaxResults(null);

        try {
            $this->admin->preBatchAction($action, $query, $idx, $allElements);

            foreach ($this->admin->getExtensions() as $extension) {
                /** @var HomepageGuardExtension|MenuGuardExtension $extension */
                $extension->preBatchAction($this->admin, $action, $query, $idx, $allElements);
            }
        } catch (ModelManagerException $e) {
            // $this->logModelManagerException($e);
            $this->addFlash('sonata_flash_error', 'flash_batch_delete_error');

            return new RedirectResponse($this->admin->generateUrl(
                'list',
                array('filter' => $this->admin->getFilterParameters())
            ));
        }

        if (count($idx) > 0) {
            $this->admin->getModelManager()->addIdentifiersToQuery($this->admin->getClass(), $query, $idx);
        } elseif (!$allElements) {
            $query = null;
        }

        return call_user_func(array($this, $finalAction), $query);
    }
}
