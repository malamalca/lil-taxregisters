<?php
namespace LilTaxRegisters\Controller;

use LilTaxRegisters\Controller\AppController;
use LilTaxRegisters\Form\PKPasswordForm;


/**
 * TaxRegisters Controller
 *
 * @property \LilTaxRegisters\Model\Table\TaxRegistersTable $TaxRegisters
 */
class TaxRegistersController extends AppController
{
    /**
     * isAuthorized method.
     *
     * @param array $user User
     * @return bool
     */
    public function isAuthorized($user)
    {
        switch ($this->request->getParam('action')) {
            case 'password':
                return true;

            default:
                return false;
        }
    }

    /**
     * Read users password on first invoice edit attempt.
     *
     * @return \Cake\Network\Response|null
     */
    public function password()
    {
        $PKPassword = new PKPasswordForm($this->request, $this->Auth->user());

        if ($this->request->isPost() && $PKPassword->execute($this->request->getData())) {
            return $this->redirect(!$this->request->data('referer') ? ['action' => 'index'] : $this->request->data('referer'));
        }

        $this->set(compact('PKPassword'));
    }

}
