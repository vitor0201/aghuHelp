<?php
namespace Mater\Controller;

use Mater\Controller\AppController;

/**
 * Resultados Controller
 *
 * @property \Mater\Model\Table\ResultadosTable $Resultados
 */
class ResultadosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorResultados']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'descricao'=> ['field'=> 'Resultados.descricao', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Resultados.ativo', 'operator'=>'='] 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterResultados']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Resultados->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id, $object->descricao, $object->ativo? 'S' : 'N'];
    		};
    		$this->Export->CSV('Resultados_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id', 'Descrição','Ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Resultados.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('resultados', $this->paginate($this->Resultados));
        $this->set('_serialize', ['resultados']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Resultado id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $resultado = $this->Resultados->get($id, [
            'contain' => ['CirurgiasProcedimentos']
        ]);
        $this->set('resultado', $resultado);
        $this->set('_serialize', ['resultado']);
    }
	*/
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $resultado = $this->Resultados->newEntity();
        if ($this->request->is('post')) {
            $resultado = $this->Resultados->patchEntity($resultado, $this->request->data);
            if ($this->Resultados->save($resultado)) {
                $this->Flash->success(__('O registro de resultado foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
//                 return $this->redirect(['action' => 'view', $resultado->id]);
            } else {
                $this->Flash->error(__('O registro de resultado não foi salvo. Por favor, tente novamente.'));
            }
        }
        
        $grupos = $this->Resultados->Grupos->find('list', ['conditions'=>['Grupos.ativo'=>true,'Grupos.sistema_id'=>$this->sistema['id']]]);
        $this->set('grupos',$grupos);
        $this->set(compact('resultado'));
        $this->set('_serialize', ['resultado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Resultado id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $resultado = $this->Resultados->get($id, [
            'contain' => ['Grupos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $resultado = $this->Resultados->patchEntity($resultado, $this->request->data);
            if ($this->Resultados->save($resultado)) {
                $this->Flash->success(__('O registro de resultado foi salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
//                 return $this->redirect(['action' => 'view', $resultado->id]);
            } else {
                $this->Flash->error(__('O registro de resultado não foi salvo. Por favor, tente novamente.'));
            }
        }
        $grupos = $this->Resultados->Grupos->find('list', ['conditions'=>['Grupos.ativo'=>true,'Grupos.sistema_id'=>$this->sistema['id']]]);
        $this->set('grupos',$grupos);
         
        $this->set(compact('resultado'));
        $this->set('_serialize', ['resultado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Resultado id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $resultado = $this->Resultados->get($id);
        if ($this->Resultados->delete($resultado)) {
            $this->Flash->success(__('O registro de resultado foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de resultado não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
