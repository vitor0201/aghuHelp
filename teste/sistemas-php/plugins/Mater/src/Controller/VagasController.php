<?php
namespace Mater\Controller;

use Mater\Controller\AppController;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
/**
 * Vagas Controller
 *
 * @property \Mater\Model\Table\VagasTable $Vagas
 */
class VagasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Salas']
        ];

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorVagas']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro1'=> ['field'=> 'Vagas.id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterVagas']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Vagas->find('all', ['conditions'=> $conditions  ,'contain' => ['Salas']   ]);
    		$callback = function ($object){
    			return [$object->id];
    		};
    		$this->Export->CSV('Vagas_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Vagas.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('vagas', $this->paginate($this->Vagas));
        $this->set('_serialize', ['vagas']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Vaga id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vaga = $this->Vagas->get($id, [
            'contain' => ['Salas', 'Agendamentos']
        ]);
        $this->set('vaga', $vaga);
        $this->set('_serialize', ['vaga']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vaga = $this->Vagas->newEntity();
        
        $salas = $this->Vagas->Salas->find('list', ['conditions' => ['ativo'=>true],'order'=>'descricao']);
        $this->set(compact('vaga', 'salas'));
        $this->set('_serialize', ['vaga']);
        
        if ($this->request->is('post')) {
        	$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
        	$this->request->data['usuario_cadastro'] = $this->login['login'];
        	
        	$vaga = $this->Vagas->patchEntity($vaga, $this->request->data);
        	
        	debug($vaga); //exit;
        	
        	$data_final = Time::createFromFormat(
        			'd/m/Y',
        			$this->request->data['data_final']
        	);
        	
        	$table = $this->Vagas;
        	$erro = false;
        	
        	$connection = ConnectionManager::get('default');
        	$connection->transactional(function ($conn) use($table, $vaga,$data_final, &$erro ) {
        		while($vaga->data->format('Ymd') <= $data_final->format('Ymd')){
        			$dia_semana = $vaga->data->format('w');

        			
        			if(!empty($vaga->dias) && !in_array($dia_semana, $vaga->dias)) {
        				$vaga->data->modify('+1 days');
        				continue;
        			}
        			
        			unset($vaga->id);
        			$vaga->isNew(true);
        			
        			if (!$this->Vagas->save($vaga)) {
        				$erro = "[".$vaga->data->format('d/m/Y') . "] Erro ao salvar. ";
        				break;
        			}
        			
        			echo $vaga->data->format('d/m w')." <br/>";
        			$vaga->data->modify('+1 days');
        			 
        			
        		}
//         		exit;
        		
        	});
        		if($erro){
        			$this->Flash->error(__('As vagas não foram salvas. Por favor, tente novamente. '. $erro));
        			
        		}
        		else{
        			$this->Flash->success(__('As vagas foram salvas com sucesso.'));
        			return $this->redirect(['action' => 'index']);
        		}
        		
        		
        }
       
    }

    /**
     * Edit method
     *
     * @param string|null $id Vaga id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*
    public function edit($id = null)
    {
        $vaga = $this->Vagas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vaga = $this->Vagas->patchEntity($vaga, $this->request->data);
            if ($this->Vagas->save($vaga)) {
                $this->Flash->success(__('O registro de vaga foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $vaga->id]);
            } else {
                $this->Flash->error(__('O registro de vaga não foi salvo. Por favor, tente novamente.'));
            }
        }
        $salas = $this->Vagas->Salas->find('list', ['limit' => 200]);
        $this->set(compact('vaga', 'salas'));
        $this->set('_serialize', ['vaga']);
    }
*/
    /**
     * Delete method
     *
     * @param string|null $id Vaga id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vaga = $this->Vagas->get($id);
        if ($this->Vagas->delete($vaga)) {
            $this->Flash->success(__('O registro de vaga foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de vaga não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function eventos(){
    	
    }
}
