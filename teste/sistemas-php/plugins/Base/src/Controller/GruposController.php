<?php
namespace Base\Controller;

use Base\Controller\AppController;

/**
 * Grupos Controller
 *
 * @property \App\Model\Table\GruposTable $Grupos
 */
class GruposController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sistemas']
        ];

        $sistemas = $this->Grupos->Sistemas->find('list');
        $this->set('sistemas',$sistemas);
        
		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorGrupos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'filtro_descricao'=> ['field'=> 'Grupos.descricao', 'operator'=>'ILIKE'],
					'filtro_ativo'=> ['field'=> 'Grupos.ativo', 'operator'=>'='],
					'filtro_sistema'=> ['field'=> 'Grupos.sistema_id', 'operator'=>'=']
					// ... 
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterGrupos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
    		$data_export = $this->Grupos->find('all', ['conditions'=> $conditions  ,'contain' => ['Sistemas']   ]);
    		$callback = function ($object){
    			return [$object->id,$object->descricao,$object->atividade,($object->ativo?'SIM':'NÃO')];
    		};
    		$this->Export->CSV('Grupos_'.date('d_m_Y_H_i_s').'.csv', $data_export, ['ID','Nome','Atividade','Status'], $callback );
    	}
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Grupos.id ASC'];
    		
    		
    	//$conditions['Grupos.sistema_id'] = $this->sistema['id']; 
    	
    	$this->paginate['conditions']	= $conditions;
    	
        $this->set('grupos', $this->paginate($this->Grupos));
        $this->set('_serialize', ['grupos']);
        
         $this->PaginationSession->save();
    }

    /**
     * View method
     *
     * @param string|null $id Grupo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grupo = $this->Grupos->get($id, [
            'contain' => ['Sistemas','Acoes','Usuarios','Parametros']
        ]);
        
        // controle de escopo
        /*
        if($grupo->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o grupo [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        $this->set('grupo', $grupo);
        $this->set('_serialize', ['grupo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $grupo = $this->Grupos->newEntity();
        if ($this->request->is('post')) {
        	
        	if($this->request->data['sigla'])
        		$this->request->data['sigla'] = mb_strtoupper($this->request->data['sigla']);
        	
        	if($this->request->data['descricao'])
        		$this->request->data['descricao'] = mb_strtoupper($this->request->data['descricao']);
        	
        	
        	//$this->request->data['sistema_id'] = $this->sistema['id'];
        	
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->data);
            
            if ($this->Grupos->save($grupo)) {
                $this->Flash->success(__('O registro de grupo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $grupo->id]);
            } else {
                $this->Flash->error(__('O registro de grupo não foi salvo. Por favor, tente novamente.'));
            }
        }
        $sistemas = $this->Grupos->Sistemas->find('list');
        //$acoes = $this->Grupos->Acoes->find('list', ['limit' => 200]);
        //$parametros = $this->Grupos->Parametros->find('list', ['limit' => 200]);
        //$usuarios = $this->Grupos->Usuarios->find('list', ['limit' => 200]);
        $this->set(compact('grupo', 'sistemas'));
        $this->set('_serialize', ['grupo']);
    }
    
    // para requisições ajax, recarregar a lista depois de escolher o sistema
    public function groups(){
    	//debug($this->request->data);
    	 
    	$grupos = $this->Grupos->find('list', ['groupField' => 'ativo', 'conditions' => ['Grupos.sistema_id'=>$this->request->data['sistema_id']]]);
    	 
    	// agrupar os grupos por ativo e inativo
    	$grupos =  $grupos->toArray();
    	if(isset($grupos[1])) $grupos['Grupos Ativos'] = $grupos[1];
    	if(isset($grupos[0])) $grupos['Grupos Inativos'] = $grupos[0];
    
    	unset($grupos[1]);
    	unset($grupos[0]);
    	 
    	foreach($grupos as $label => $agr) {
    		echo "<optgroup label='$label' > ";
    		foreach($agr as $id => $grp){
    			echo "<option value='$id'> $grp</option>";
    		}
    		echo "</optgroup>";
    	}
    	exit;
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grupo = $this->Grupos->get($id, [
         //	'contain'=>[   'Acoes']
        ]);
        
        // controle de escopo
        /*
        if($grupo->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o grupo [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        if ($this->request->is(['patch', 'post', 'put'])) {
        	
        	if($this->request->data['sigla'])
        		$this->request->data['sigla'] = mb_strtoupper($this->request->data['sigla']);
        	 
        	if($this->request->data['descricao'])
        		$this->request->data['descricao'] = mb_strtoupper($this->request->data['descricao']);
        	
        	unset($this->request->data['sistema_id']);
        	
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->data);
            if ($this->Grupos->save($grupo)) {
                $this->Flash->success(__('O registro de grupo foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $grupo->id]);
            } else {
                $this->Flash->error(__('O registro de grupo não foi salvo. Por favor, tente novamente.'));
            }
        
        }
       // $acoes = $this->Grupos->Acoes->find('list', ['keyField' => 'id', 'valueField' => 'controller']);
        
        //$sistemas = $this->Grupos->Sistemas->find('list', ['limit' => 200]);
        $this->set(compact('grupo'));
        $this->set('_serialize', ['grupo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grupo = $this->Grupos->get($id);
        
        // controle de escopo
        /*
        if($grupo->sistema_id != $this->sistema['id']){
        	$this->Flash->error(__("Não é possível alterar o grupo [$id]."));
        	return $this->redirect(['action' => 'index']);
        }
        */
        
        if ($this->Grupos->delete($grupo)) {
            $this->Flash->success(__('O registro de grupo foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O registro de grupo não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
