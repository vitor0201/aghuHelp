<?php
namespace Mater\Controller;

use Mater\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Medicos Controller
 *
 * @property \Mater\Model\Table\MedicosTable $Medicos
 */
class MedicosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorMedicos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
				'nome'=> ['field'=> 'Medicos.nome', 'operator'=>'ILIKE'] ,
				'ativo'=> ['field'=> 'Medicos.ativo', 'operator'=>'='] ,
				'preceptor'=> ['field'=> 'Medicos.preceptor', 'operator'=>'='],
				'residente'=> ['field'=> 'Medicos.residente', 'operator'=>'=']
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterMedicos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Medicos->find('all', ['conditions'=> $conditions   ]);
    		$callback = function ($object){
    			return [$object->id,$object->nome,$object->crm,$object->preceptor?'S':'N',$object->residente?'S':'N', $object->ativo?'S':'N' ];
    		};
    		$this->Export->CSV('Medicos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['id','Nome' ,'CRM','Preceptor','Residente','Ativo'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Medicos.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('medicos', $this->paginate($this->Medicos));
        $this->set('_serialize', ['medicos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Medico id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
    	
    	$periodos = $this->Medicos->Disponibilidades->Periodos->find('list', ['conditions' => ['ativo'=>true]])->toArray();
    	$this->set('periodos',$periodos);
    	
        $medico = $this->Medicos->get($id, [
            'contain' => ['Procedimentos', 'Disponibilidades']
        ]);
        $this->set('medico', $medico);
        $this->set('_serialize', ['medico']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $medico = $this->Medicos->newEntity();
        
       	$periodos = $this->Medicos->Disponibilidades->Periodos->find('list', ['conditions' => ['ativo'=>true]])->toArray();
        $this->set('periodos',$periodos);
       	
        if ($this->request->is('post')) {
//         	debug($this->request->data); exit;
        	
            $medico = $this->Medicos->patchEntity($medico, $this->request->data);
            if ($this->Medicos->save($medico)) {
                $this->Flash->success(__('O médico foi salvo com sucesso.'));
                
                
                /*
                 * SALVA AS DISPONIBILIDADES DO MEDICO
                 */
                // In a controller.
                $disponibilidades = $this->Medicos->Disponibilidades->patchEntities($disps, $this->request->data['Disponibilidades']);
                
                $dpTable = TableRegistry::get('Mater.Disponibilidades');
                
                $erro_salvar_disp = false;
                
				$dpTable->connection()->transactional(function () use ($medico, $disponibilidades, $dpTable, $erro_salvar_disp) {
                	foreach ($disponibilidades as $entity) {
                		$entity->medico_id = $medico->id;
                		if(!$dpTable->save($entity, ['atomic' => false])){
                			$erro_salvar_disp = true;
                			break;
                		}
                	}
                });
				
				if($erro_salvar_disp){
					$this->Flash->error(__('Falha ao salvar as disponibilidades.'));
				}
                
                
                return $this->redirect(['action' => 'view', $medico->id]);
            } else {
                $this->Flash->error(__('O médico não foi salvo. Por favor, tente novamente.'));
            }
        }
        $procedimentos = $this->Medicos->Procedimentos->find('list', []);
        $this->set(compact('medico', 'procedimentos'));
        $this->set('_serialize', ['medico']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Medico id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	
    	$periodos = $this->Medicos->Disponibilidades->Periodos->find('list', ['conditions' => ['ativo'=>true]])->toArray();
    	$this->set('periodos',$periodos);
    	
        $medico = $this->Medicos->get($id, [
            'contain' => ['Procedimentos','Disponibilidades']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $medico = $this->Medicos->patchEntity($medico, $this->request->data);
            if ($this->Medicos->save($medico)) {
                $this->Flash->success(__('O médico foi salvo com sucesso.'));
                
                /*
                 * SALVA AS DISPONIBILIDADES DO MEDICO
                */
                $disponibilidades = $this->Medicos->Disponibilidades->patchEntities($disps, $this->request->data['Disponibilidades']);
                
                $dpTable = TableRegistry::get('Mater.Disponibilidades');
                
                $erro_salvar_disp = false;
                
//                 debug($disponibilidades); exit;
                
                $dpTable->connection()->transactional(function () use ($medico, $disponibilidades, $dpTable, $erro_salvar_disp) {

                	$dpTable->deleteAll(['medico_id'=>$medico->id]);
                	
                	foreach ($disponibilidades as $entity) {
                		if(!$dpTable->save($entity, ['atomic' => false])){
                			$erro_salvar_disp = true;
                			break;
                		}
                	}
                });
                
				if($erro_salvar_disp){
					$this->Flash->error(__('Falha ao salvar as disponibilidades.'));
				}
                
                
                return $this->redirect(['action' => 'view', $medico->id]);
            } else {
                $this->Flash->error(__('O médico não foi salvo. Por favor, tente novamente.'));
            }
        }
        $procedimentos = $this->Medicos->Procedimentos->find('list', ['limit' => 200]);
        $this->set(compact('medico', 'procedimentos'));
        $this->set('_serialize', ['medico']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Medico id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $medico = $this->Medicos->get($id);
        if ($this->Medicos->delete($medico)) {
            $this->Flash->success(__('O médico foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O médico não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    // para requisições ajax, recarregar a lista de procedimentos depois de escolher o medico
    public function portifolio(){
//     	debug($this->request->data); exit;
    
    	$medico_id = $this->request->data['medico_id'];
    	
    	$medico = $this->Medicos->get($medico_id, [
    			'contain' => ['Procedimentos']
    			]);
    	
    	if(!empty($medico->procedimentos)) {
	    	foreach($medico->procedimentos as $proc) {
	    		if(!$proc->ativo) continue;
	    		echo "<option value='$proc->id'>$proc->codigo $proc->descricao2 </option>";
	    	}
    	}

    	exit;
    }
}
