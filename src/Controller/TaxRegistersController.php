<?php
namespace LilTaxRegisters\Controller;

use Cake\ORM\TableRegistry;
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
            case 'confirm':
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

    /**
     * Confirm invoice
     *
     * @return \Cake\Network\Response|null
     */
    public function confirm($invoiceId)
    {
        $Invoices = TableRegistry::get('LilInvoices.Invoices');

        if ($invoice = $Invoices->get($invoiceId)) {
            $InvoicesCounters = TableRegistry::get('LilInvoices.InvoicesCounters');
            $InvoicesTaxconfirmations = TableRegistry::get('LilTaxRegisters.InvoicesTaxconfirmations');
            $counter = $InvoicesCounters->get($invoice->counter_id);
            if ($counter->tax_confirmation) {
                $session = $this->request->getSession();
                $p12 = $session->read('LilTaxRegisters.P12');
                $p12Password = $session->read('LilTaxRegisters.PKPassword');

                $InvoicesTaxconfirmations->signAndSend($invoice->id, $this->Auth->user('company'), $p12, $p12Password);

                $this->redirect(['plugin' => 'LilInvoices', 'controller' => 'Invoices', 'action' => 'view', $invoice->id]);
            }
        }
    }

}
