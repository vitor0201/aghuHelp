<?php
namespace Sms\Controller;

use Sms\Controller\AppController;

/**
 * Historicos Controller
 *
 * @property \Sms\Model\Table\HistoricosTable $Historicos
 */
class HistoricosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {


        $this->set('historicos', $this->Hisotricos->find('all'));
        $this->set('_serialize', ['historicos']);
        
        
    }

    /**
     * View method
     *
     * @param string|null $id Historico id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $historico = $this->Historicos->get($id, [
            'contain' => []
        ]);
        $this->set('historico', $historico);
        $this->set('_serialize', ['historico']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $historico = $this->Historicos->newEntity();
        if ($this->request->is('post')) {
            $historico = $this->Historicos->patchEntity($historico, $this->request->data);
            if ($this->Historicos->save($historico)) {
                $this->Flash->success(__('O registro de historico foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $historico->id]);
            } else {
                $this->Flash->error(__('O registro de historico não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('historico'));
        $this->set('_serialize', ['historico']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Historico id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $historico = $this->Historicos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $historico = $this->Historicos->patchEntity($historico, $this->request->data);
            if ($this->Historicos->save($historico)) {
                $this->Flash->success(__('O registro de historico foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $historico->id]);
            } else {
                $this->Flash->error(__('O registro de historico não foi salvo. Por favor, tente novamente.'));
            }
        }
        $this->set(compact('historico'));
        $this->set('_serialize', ['historico']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Historico id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $historico = $this->Historicos->get($id);
        if ($this->Historicos->delete($historico)) {
            $this->Flash->success(__('O registro de historico foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de historico não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
