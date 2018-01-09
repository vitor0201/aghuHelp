<?php
namespace Mater\Controller;

use Mater\Controller\AppController;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
/**
 * Bloqueios Controller
 *
 * @property \Mater\Model\Table\BloqueiosTable $Bloqueios
 */
class BloqueiosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Medicos']
        ];

        $this->set('medicos', $this->Bloqueios->Medicos->find('list',['conditions'=>['ativo'=>true],'order'=>'nome']));
        
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorBloqueios']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'data_inicio'=> ['field'=> 'Bloqueios.data', 'operator'=>'>='],
					'data_fim'=> ['field'=> 'Bloqueios.data', 'operator'=>'<='],
					'medico_id'=> ['field'=> 'Bloqueios.id', 'operator'=>'=']
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterBloqueios']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Bloqueios->find('all', ['conditions'=> $conditions  ,'contain' => ['Medicos']   ]);
    		$callback = function ($object){
    			return [$object->data->format('d/m/Y'),$object->medico->nome, $object->justificativa];
    		};
    		$this->Export->CSV('Bloqueios_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['Data','Médico','Justificativa'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Bloqueios.id ASC'];
    		
    		
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('bloqueios', $this->paginate($this->Bloqueios));
        $this->set('_serialize', ['bloqueios']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Bloqueio id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($medico_id = null)
    {
    	$periodos = $this->Bloqueios->Medicos->Disponibilidades->Periodos->find('list', ['conditions' => ['ativo'=>true]])->toArray();
    	$this->set('periodos',$periodos);
    	
        $medico = $this->Bloqueios->Medicos->get($medico_id, [
            'contain' => ['Bloqueios','Disponibilidades'],
//         	'conditions'=> ['Bloqueios.medico_id'=>$medico_id]
        ]);
        
        $this->set('medico', $medico);
        $this->set('_serialize', ['bloqueios']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bloqueio = $this->Bloqueios->newEntity();
        if ($this->request->is('post')) {
        	
        	$this->request->data['usuario_cadastro'] = $this->login['login'];
        	$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
        	
        	if(!$this->request->data['data_fim'] )
        		$this->request->data['data_fim'] = $this->request->data['data'];
        	
        	$data_final = Time::createFromFormat(
        			'd/m/Y',
        			$this->request->data['data_fim']
        	);
        	
        	$bloqueio = $this->Bloqueios->newEntity();
            $bloqueio = $this->Bloqueios->patchEntity($bloqueio, $this->request->data);
            
//             debug($bloqueio); 
            
           
//             debug($bloqueio->data->format('Ymd'));
//             debug($data_final->format('Ymd')); exit;

            $table = $this->Bloqueios;
            $erro = false;
            
            $connection = ConnectionManager::get('default');
            $connection->transactional(function ($conn) use($table, $bloqueio,$data_final, &$erro ) {
//             	$conn->execute('UPDATE articles SET published = ? WHERE id = ?', [true, 2]);
//             	$conn->execute('UPDATE articles SET published = ? WHERE id = ?', [false, 4]);

            	do {
            		 
            		if (!$table->save($bloqueio)) {
//             			$this->Flash->error(__('O registro de bloqueio não foi salvo. Por favor, tente novamente.'));
            			$erro = "[".$bloqueio->data->format('d/m/Y') . "] Erro ao salvar. ";
//             			debug($bloqueio->errors()); exit;
            			break;
            		}
            		$bloqueio->data->modify('+1 days');
            	
            		unset($bloqueio->id);
            		$bloqueio->isNew(true);
            		$table->save($bloqueio);
            		 
            		$compare_data  = $bloqueio->data->format('Ymd');
            		$compare_final = $data_final->format('Ymd');
            		 
            	} while( $compare_data < $compare_final);
            	
            	
            });
            
            if($erro){
            	$this->Flash->error(__('O bloqueio não foi salvo. Por favor, tente novamente. '. $erro));
            }
            else{
            	$this->Flash->success(__('O bloqueio foi salvo com sucesso.'));
            }
            
//             do {
            	
//             	if (!$this->Bloqueios->save($bloqueio)) {
//             		$this->Flash->error(__('O registro de bloqueio não foi salvo. Por favor, tente novamente.'));
//             		return $this->redirect(['action' => 'index',]);
//             	}
//             	$bloqueio->data->modify('+1 days');
				
//             	unset($bloqueio->id);
//             	$bloqueio->isNew(true);
//             	$this->Bloqueios->save($bloqueio);
            	
//             	$compare_data  = $bloqueio->data->format('Ymd');
//             	$compare_final = $data_final->format('Ymd');
            	
//             } while( $compare_data < $compare_final);

            return $this->redirect(['action' => 'index']);
          
            
        }
        $medicos = $this->Bloqueios->Medicos->find('list', ['limit' => 200]);
        $this->set(compact('bloqueio', 'medicos'));
        $this->set('_serialize', ['bloqueio']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Bloqueio id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bloqueio = $this->Bloqueios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bloqueio = $this->Bloqueios->patchEntity($bloqueio, $this->request->data);
            if ($this->Bloqueios->save($bloqueio)) {
                $this->Flash->success(__('O registro de bloqueio foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $bloqueio->id]);
            } else {
                $this->Flash->error(__('O registro de bloqueio não foi salvo. Por favor, tente novamente.'));
            }
        }
        $medicos = $this->Bloqueios->Medicos->find('list', ['order' => 'nome','conditions'=>['ativo'=>true]]);
        $this->set(compact('bloqueio', 'medicos'));
        $this->set('_serialize', ['bloqueio']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Bloqueio id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bloqueio = $this->Bloqueios->get($id);
        if ($this->Bloqueios->delete($bloqueio)) {
            $this->Flash->success(__('O registro de bloqueio foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de bloqueio não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
