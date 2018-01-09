<?php
namespace Mater\Controller;

use Mater\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
/**
 * Agendamentos Controller
 *
 * @property \Mater\Model\Table\AgendamentosTable $Agendamentos
 */
class AgendamentosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Situacoes', 'Salas','Preceptor','CirurgiasProcedimentos.Procedimentos']
        ];
        
        $preceptor = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>true],'order'=>'Medicos.nome']);
        $this->set('medicos', $preceptor);
         
        $situacoes = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
        $this->set('situacoes', $situacoes);
         
        $salas = $this->Agendamentos->Salas->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
        $this->set('salas',$salas);
         
        $procedimentos = $this->Agendamentos->CirurgiasProcedimentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'descricao']);
        $this->set('procedimentos',$procedimentos);
        
        

		$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorAgendamentos']);
    	$this->PaginationSession->restore();

		$this->loadComponent('Base.Filter');
		$this->Filter->addFilter([
					'data_inicio'=> ['field'=> 'Agendamentos.data', 'operator'=>'>='],
					'data_fim'=> ['field'=> 'Agendamentos.data', 'operator'=>'<='],
					'situacao_id'=> ['field'=> 'Agendamentos.situacao_id', 'operator'=>'IN'],
				'sala_id'=> ['field'=> 'Agendamentos.sala_id', 'operator'=>'IN'],
				'medico_id'=> ['field'=> 'Agendamentos.medico_id', 'operator'=>'IN'],
				'procedimento_id'=> ['field'=> 'Procedimentos.id', 'operator'=>'='],
				'paciente_prontuario'=> ['field'=> 'Agendamentos.paciente_prontuario', 'operator'=>'ILIKE'],
				'paciente_nome'=> ['field'=> 'Agendamentos.paciente_nome', 'operator'=>'ILIKE'],
		]);
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterAgendamentos']);
    	$this->set('url', $this->Filter->getUrl());
    	
    
    	
    	
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    		
    	if(!isset($this->request->query['order']))
    		$this->paginate['order'] = ['Agendamentos.data DESC'];
    		

    	$procedimento_id = null;
    	if(isset($conditions['Procedimentos.id'])){
    		$procedimento_id = $conditions['Procedimentos.id'];
    		unset($conditions['Procedimentos.id']);
    	}
    	
    	$this->paginate['conditions']	= $conditions;
    	
//     	debug($this->paginate); exit;
    	
    	$query = $this->Agendamentos->find('all', $this->paginate);
    	
    	if($procedimento_id){
    		$query->matching('CirurgiasProcedimentos', function ($q) use ($procedimento_id) {
    			return $q->where(['CirurgiasProcedimentos.procedimento_id IN' => $procedimento_id ]);
    		});
    	
    	}
    	
    	// Export CSV
    	if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    		$this->loadComponent('Base.Export');
//     		$data_export = $this->Agendamentos->find('all', ['conditions'=> $conditions  ,'contain' => ['Periodos', 'Situacoes', 'Salas']   ]);
    		$query->limit();
    		$callback = function ($object){
    			$procs = [];
    			foreach ($object->cirurgias_procedimentos as $p){
    				$procs[] = $p->procedimento->descricao2;
    			}
    			$procs = implode(', ', $procs);
    			return [$object->data->format('d/m/Y'),$object->horario->format('H:i'),$object->sala->descricao,$object->preceptor->nome,$object->paciente_prontuario,$object->paciente_nome,$procs,$object->material_especial,$object->situacao->descricao,];
    		};
    		$this->Export->CSV('Mapa_'.date('d_m_Y').'.csv', $query, ['Data','Hora','Sala','Médico','Prontuário','Paciente','Procedimentos','Material_Especial','Situação'], $callback );
    	}
    	
        $this->set('agendamentos', $query );
        $this->paginate($this->Agendamentos);
        $this->set('_serialize', ['agendamentos']);
        
         $this->PaginationSession->save();
    }
    
    public function calendar($start=null){
    	
    	$dados_filtrados = $this->request->session()->read('caledarFiltros');
//     	debug($dados_filtrados);
		if(!empty($dados_filtrados))
    		$this->request->data = $dados_filtrados; // mantem os filtros aplicados mesmo se sair para outra tela.
    	
    	$legendas = $this->Agendamentos->Situacoes->find('all',['conditions'=>['ativo'=>true],'order'=>'descricao']);
    	$this->set('legendas', $legendas);
    	
    	$defaultDate = $this->request->session()->read('calendar.defaultDate');
    	
    	if(!$defaultDate){
    		$defaultDate = date('Y-m-d');
    		$this->request->session()->write('calendar.defaultDate', $defaultDate);
    		
    	}
//     	echo $defaultDate;
    	$this->set('defaultDate', $defaultDate);
    	
    	
    	$preceptor = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>true],'order'=>'Medicos.nome']);
    	$this->set('preceptor',$preceptor);
    	
   	
    	$resultados = $this->Agendamentos->CirurgiasProcedimentos->Resultados->find('list', ['conditions' => ['Resultados.ativo'=>true],'order'=>'descricao']);
    	$this->set('resultados',$resultados);
    	 
    	$situacoes = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
    	$this->set('situacoes', $situacoes);
    	
    	$salas = $this->Agendamentos->Salas->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
    	$this->set('salas',$salas);
    	
    	$procedimentos = $this->Agendamentos->CirurgiasProcedimentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'descricao']);
    	$this->set('procedimentos',$procedimentos);
    	
    	
    	
    }
    
    public function eventos(){
//     	sleep(3);
//     	$inicio = $this->request->query['start'];
//     	$fim = $this->request->query['end'];
    	
    	
    	
    	$dados_filtrados = $this->request->query;
    	
    	$this->request->session()->write('caledarFiltros',$dados_filtrados);
    
    	$this->loadComponent('Base.Filter');
    	$this->Filter->addFilter([
    			'start'=>['field'=> 'Agendamentos.data', 'operator'=>'>='],
    			'end'=>['field'=> 'Agendamentos.data', 'operator'=>'<='],
    			'situacao_id'=> ['field'=> 'Agendamentos.situacao_id', 'operator'=>'IN'],
    			'sala_id'=> ['field'=> 'Agendamentos.sala_id', 'operator'=>'IN'],
    			'medico_id'=> ['field'=> 'Agendamentos.medico_id', 'operator'=>'IN'],
    			'prontuario'=> ['field'=> 'Agendamentos.paciente_prontuario', 'operator'=>'ILIKE'],
    			'procedimento_id'=> ['field'=> 'Procedimentos.id', 'operator'=>'='],
		]);
    	 
    	
    	
    	$conditions = $this->Filter->getConditions(['session'=>'filterCalendarAgendamentos']);
//     	$this->set('url', $this->Filter->getUrl());
//     	$conditions['CirurgiasProcedimentos.procedimento_id']=1;
    	
//     	debug($this->request->query);
    	
    	$procedimento_id = null;
    	if(isset($conditions['Procedimentos.id'])){
    		$procedimento_id = $conditions['Procedimentos.id'];
    		unset($conditions['Procedimentos.id']);
    	}
    	
//     	debug($conditions); exit;
    	if($dados_filtrados['somente_vagas'] && $dados_filtrados['somente_vagas']!='a')
    		$conditions['Agendamentos.id']=0;
    	
    	
    	$agendamentos = $this->Agendamentos->find('all'  ,['contain'=>['Situacoes', 'CirurgiasProcedimentos.Procedimentos'], 'conditions'=> $conditions] );
    	
//     	$vagas = $this->Agendamentos->Vagas->find('all', [ 'contain' => ['Agendamentos','Salas'], 'conditions'=> ['Vagas.data >='=>$dados_filtrados['start'],'Vagas.data <='=>$dados_filtrados['end']] ] );
    	$conditions_vagas['Vagas.data >='] = $dados_filtrados['start'];
    	$conditions_vagas['Vagas.data <='] = $dados_filtrados['end'];
    	if($dados_filtrados['sala_id'])
    		$conditions_vagas['Vagas.sala_id IN'] = $dados_filtrados['sala_id'];
    	
    	if($dados_filtrados['somente_vagas'] && $dados_filtrados['somente_vagas']!='v')
    		$conditions_vagas['Vagas.id']=0;
    	 
    	$vagas = $this->Agendamentos->Vagas->find('all', [ 'contain' => ['Agendamentos','Salas'], 'conditions'=> 
    			$conditions_vagas
		] );
    	 
    	
    	
//     	debug($procedimento_id); exit;
    	if($procedimento_id){
	    	$agendamentos->matching('CirurgiasProcedimentos', function ($q) use ($procedimento_id) {
	    		return $q->where(['CirurgiasProcedimentos.procedimento_id IN' => $procedimento_id ]);
	    	});
	    	
    	}
    	
    	
     	
    	
    	$eventos = [];
    	$i=0;
    	foreach($vagas as $ev) {
    		
    		$estaVago = true;
    		foreach ($ev->agendamentos as $agenda){
    			if(in_array($agenda->situacao_id, [1,2]) ){
    				$estaVago = false;
    				break;
    			}
    				
    		}
    		if(!$estaVago)
    			continue;
    		
//     		debug($ev) ;exit;
    		$eventos[$i]['id'] =  'v'.$ev->id;
    		$eventos[$i]['title'] = $ev->sala->descricao ;
    		$data = explode('/',substr($ev->data,0,10));
    		$horario =  $ev->horario->format('H:i:s');
    		$inicio = $ev->data->modify('+'.$ev->horario->hour.' hours');
    		$inicio = $ev->data->modify('+'.$ev->horario->minute.' minutes');
    		
    		$eventos[$i]['start'] = $inicio->format('Y-m-d') . 'T'. $inicio->format('H:i:s');
    		
    		$fim = $inicio->modify('+30 minutes');
    		 
    		$eventos[$i]['end'] = $fim->format('Y-m-d') . 'T'. $fim->format('H:i:s');
    		
    		$eventos[$i]['backgroundColor'] ='#fff';
    		
    		#337ab7
    		$eventos[$i]['borderColor'] ='#337ab7';
    		$eventos[$i]['textColor'] ='#27a0c9';
    		
//     		$eventos[$i]['borderColor'] ='#1460d1';
//     		$eventos[$i]['textColor'] ='#1460d1';
    		$eventos[$i]['url'] = Router::url(['controller' => 'agendamentos', 'action' => 'add', $ev->id]);
    		$i++;
    		
    	}
    	
    	
    	foreach($agendamentos as $ev){
    		$eventos[$i]['id'] =  $ev->id;
    		$eventos[$i]['title'] =  $ev->id;
    		
    		$data = explode('/',substr($ev->data,0,10));
    		
    		$horario =  $ev->horario->format('H:i:s');
      		
    		$inicio = $ev->data->modify('+'.$ev->horario->hour.' hours');
    		$inicio = $ev->data->modify('+'.$ev->horario->minute.' minutes');
    		
    		$eventos[$i]['start'] = $inicio->format('Y-m-d') . 'T'. $inicio->format('H:i:s');
    		
//     		if($ev->duracao->hour >= 1) {
	    		$fim = $inicio->modify('+'.$ev->duracao->hour.' hours');
	    		$fim = $fim->modify('+'.$ev->duracao->minute.' minutes');
	    		
	    		$eventos[$i]['end'] = $fim->format('Y-m-d') . 'T'. $fim->format('H:i:s');
//     		}
//     		debug($ev);
    		$desc = [];
    		foreach ($ev->cirurgias_procedimentos as $proc){
//     			debug($proc->procedimento->sigla);
    			$desc[] = $proc->procedimento->sigla;
    		}
//     		debug(implode(',', $desc));
//     		if(!count($desc))
//     			$desc[] = " ";
    		
    		$eventos[$i]['title'] = implode(', ', $desc); 
    		
    		$eventos[$i]['backgroundColor'] =$ev->situacao->cor_agenda;
    		$eventos[$i]['borderColor'] =$ev->situacao->cor_agenda;
    		
    		$i++;
    	}
    	
//     	exit;
    	$this->set('eventos', $eventos);
    	
    	$this->set('_serialize', 'eventos');
    	
//     	$this->request->session()->destroy();
    }

    /**
     * View method
     *
     * @param string|null $id Agendamento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
//     	sleep(3);
        $agendamento = $this->Agendamentos->get($id, [
            'contain' => [ 'Situacoes', 'Salas','Medicos','CirurgiasProcedimentos','CirurgiasProcedimentos.Resultados','CirurgiasProcedimentos.Motivos', 'CirurgiasProcedimentos.Procedimentos.Documentos', 'Preceptor']
        ]);
        
        $prontuario = $agendamento->paciente_prontuario;
        
        $historico = $this->Agendamentos->find('all', ['conditions'=>['Agendamentos.paciente_prontuario'=>$prontuario, 'Agendamentos.id <>'=>$id],'order'=>'Agendamentos.data DESC','contain' => [ 'Situacoes', 'Salas','CirurgiasProcedimentos','CirurgiasProcedimentos.Procedimentos','Preceptor']]);
        
        $this->set('historico', $historico);
//         debug($agendamento);
        $this->set('agendamento', $agendamento);
        $this->set('_serialize', ['agendamento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($vaga_id)
    {
    	$vaga = $this->Agendamentos->Vagas->get($vaga_id);
    	$this->request->data['sala_id'] = $vaga->sala_id;
    	$this->request->data['data'] = $vaga->data->format('d/m/Y');
    	$this->request->data['horario'] = $vaga->horario->format('H:i:s');
    	$this->request->data['vaga_id'] = $vaga_id;
    	
    	$this->set('vaga', $vaga);
    	
        $agendamento = $this->Agendamentos->newEntity();
        
        
        if ($this->request->is('post')) {
        	$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
        	$this->request->data['usuario_cadastro'] = $this->login['login'];
        	
			$this->request->data['sala_id'] = $vaga->sala_id;
	    	$this->request->data['data'] = $vaga->data->format('d/m/Y');
	    	$this->request->data['horario'] = $vaga->horario->format('H:i:s');
	    	$this->request->data['vaga_id'] = $vaga_id;
// 	    	$this->request->data['situacao_id'] = 2;
        	
        	$agendamento = $this->Agendamentos->newEntity($this->request->data, [ 'associated' => ['CirurgiasProcedimentos', 'CirurgiasProcedimentos.Motivos','Medicos'] ]);
        	
//             $agendamento = $this->Agendamentos->patchEntity($agendamento, $this->request->data);
            
//             debug($this->request->data); //exit;
           
//             debug($agendamento); exit; 
            
            if ($this->Agendamentos->save($agendamento, [ 'atomic'=>false , 'associated' => ['CirurgiasProcedimentos', 'CirurgiasProcedimentos.Motivos','Medicos'] ])) {
                $this->Flash->success(__('O  agendamento foi salvo com sucesso.'));
//                 return $this->redirect(['action' => 'view', $agendamento->id]);
                return $this->redirect(['action' => 'calendar']);
            } else {
            	debug($agendamento);
                $this->Flash->error(__('O  agendamento não foi salvo. Por favor, tente novamente.'));
            }
        }
        
        $preceptor = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>true],'order'=>'Medicos.nome']);
        $this->set('preceptor',$preceptor);
        
        $residentes = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>false],'order'=>'Medicos.nome']);
        $this->set('residentes',$residentes);

        $procedimentos = $this->Agendamentos->CirurgiasProcedimentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'descricao']);
        $this->set('procedimentos',$procedimentos);
        
        $resultados = $this->Agendamentos->CirurgiasProcedimentos->Resultados->find('list', ['contain'=>[],'conditions' => ['Resultados.ativo'=>true],'order'=>'Resultados.descricao']);
        
        $my_groups = $this->getGroups();
        
        $resultados->matching('Grupos', function ($q) use ($my_groups) {
        	return $q->where(['Grupos.id IN' => $my_groups ]);
        });
        
        $this->set('resultados',$resultados);
        
        $motivos = $this->Agendamentos->CirurgiasProcedimentos->Motivos->find('list', ['conditions' => ['Motivos.ativo'=>true],'order'=>'descricao']);
        $this->set('motivos',$motivos);
       
        $situacoes = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
        $salas = $this->Agendamentos->Salas->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
        
        
        
        $this->set(compact('agendamento', 'situacoes', 'salas'));
        $this->set('_serialize', ['agendamento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Agendamento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*
    public function edit($id = null)
    {
        $agendamento = $this->Agendamentos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $agendamento = $this->Agendamentos->patchEntity($agendamento, $this->request->data);
            if ($this->Agendamentos->save($agendamento)) {
                $this->Flash->success(__('O  agendamento foi salvo com sucesso.'));
                return $this->redirect(['action' => 'view', $agendamento->id]);
            } else {
            	
                $this->Flash->error(__('O  agendamento não foi salvo. Por favor, tente novamente.'));
            }
        }
        $periodos = $this->Agendamentos->Periodos->find('list', ['limit' => 200]);
        $situacoes = $this->Agendamentos->Situacoes->find('list', ['limit' => 200]);
        $salas = $this->Agendamentos->Salas->find('list', ['limit' => 200]);
        $this->set(compact('agendamento', 'periodos', 'situacoes', 'salas'));
        $this->set('_serialize', ['agendamento']);
    }
*/
    
    public function edit($id = null)
    {
    	
    	$agendamento = $this->Agendamentos->get($id, [
    			'contain' => ['CirurgiasProcedimentos','CirurgiasProcedimentos.Motivos','Medicos']
    	]);

    	 if ($this->request->is(['patch', 'post', 'put'])) {
    		
    		$this->request->data['data_cadastro'] = date('d/m/Y H:i:s');
    		$this->request->data['usuario_cadastro'] = $this->login['login'];
    		
    		$agendamento = $this->Agendamentos->patchEntity($agendamento, $this->request->data , ['associated' => ['CirurgiasProcedimentos','CirurgiasProcedimentos.Motivos', 'Medicos'] ]);
    		
//     		debug($agendamento); exit;
    		
    		
    		if ($this->Agendamentos->save($agendamento, [ 'associated' => ['CirurgiasProcedimentos','CirurgiasProcedimentos.Motivos', 'Medicos'] ])) {
    			
    			if($this->request->data['nova_data'] && $agendamento->situacao_id == 5){ // 5 = Remarcar
    				
    				$nova_vaga = $this->Agendamentos->Vagas->get($this->request->data['nova_data']); // id da nova vaga ...
    				
    				$agendamento_novo = $this->Agendamentos->newEntity($this->request->data, [ 'associated' => ['CirurgiasProcedimentos','Medicos'] ]);
    				
    				$agendamento_novo->data = $nova_vaga->data->format('d/m/Y');
    				$agendamento_novo->horario = $nova_vaga->horario->format('H:i:s');
    				$agendamento_novo->sala_id = $nova_vaga->sala_id;
    				$agendamento_novo->vaga_id = $nova_vaga->id;
    				
    				$agendamento_novo->data_cadastro = date('d/m/Y H:i:s');
    				$agendamento_novo->usuario_cadastro = $this->login['login'];
    				
    				$agendamento_novo->remarcado_id = $id;
    				$agendamento_novo->situacao_id = 2;
    				
    				$this->Agendamentos->save($agendamento_novo, [ 'associated' => ['CirurgiasProcedimentos', 'Medicos'] ]);
    				$this->Flash->success(__('Remarcado com sucesso com sucesso.'));
    				return $this->redirect(['action' => 'calendar']);
    			}
    			
    			$this->Flash->success(__('O  agendamento foi salvo com sucesso.'));
//     			return $this->redirect(['action' => 'view', $agendamento->id]);
    			return $this->redirect(['action' => 'calendar']);
    		} else {
				
    			$this->Flash->error(__('O  agendamento não foi salvo. Por favor, tente novamente.'));
    		}
    	}
    
    	$preceptor = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>true],'order'=>'Medicos.nome']);
    	$this->set('preceptor',$preceptor);
    
    	$residentes = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>false],'order'=>'Medicos.nome']);
    	$this->set('residentes',$residentes);
    
    	$procedimentos = $this->Agendamentos->CirurgiasProcedimentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'descricao']);
    	$this->set('procedimentos',$procedimentos);
    
//     	$resultados = $this->Agendamentos->CirurgiasProcedimentos->Resultados->find('list', ['conditions' => ['Resultados.ativo'=>true],'order'=>'descricao']);
//     	$this->set('resultados',$resultados);
    	
    	$resultados = $this->Agendamentos->CirurgiasProcedimentos->Resultados->find('list', ['contain'=>[],'conditions' => ['Resultados.ativo'=>true],'order'=>'Resultados.descricao']);
    	
    	$my_groups = $this->getGroups();
    	
    	$resultados->matching('Grupos', function ($q) use ($my_groups) {
    		return $q->where(['Grupos.id IN' => $my_groups ]);
    	});
    	$this->set('resultados',$resultados);
    	
    	$motivos = $this->Agendamentos->CirurgiasProcedimentos->Motivos->find('list', ['conditions' => ['Motivos.ativo'=>true],'order'=>'descricao']);
    	$this->set('motivos',$motivos);
    	 
    	$situacoes = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
    	$salas = $this->Agendamentos->Salas->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
    
    	$vagas = $this->Agendamentos->Vagas
    	->find('all', ['contain'=>['Salas','Agendamentos'],'conditions'=>['Vagas.data >='=>date('d/m/Y')],'order'=>'Vagas.data'])
    	->notMatching('Agendamentos', function ($q) {
	        return $q->where(['Agendamentos.situacao_id IN' => [1,2] ]); // agendada e realizada
	    });;
    	
	    $semana = ['Domingo', 'Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];
    	$vg = [];
    	foreach($vagas as $vaga){
    		$vg[$vaga->id] = $vaga->sala->descricao . " - " . $vaga->data->format('d/m/Y') . " - " . $vaga->horario->format('H:i').'h - '. $semana[$vaga->data->format('w')];
    	}
    	
    	$this->set('vagas', $vg);
    	
    	$this->set(compact('agendamento', 'situacoes', 'salas'));
    	$this->set('_serialize', ['agendamento']);
    }
    /**
     * Delete method
     *
     * @param string|null $id Agendamento id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $agendamento = $this->Agendamentos->get($id);
        if ($this->Agendamentos->delete($agendamento)) {
            $this->Flash->success(__('O  agendamento foi removido com sucesso.'));
        } else {
            $this->Flash->error(__('O  agendamento não foi removido. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'calendar']);
    }
    
    public function relatorio(){

    	$agendamentos = $this->Agendamentos->CirurgiasProcedimentos->find("all",[
				'contain' => ['Procedimentos','Agendamentos',],
    			'order' => ['Procedimentos.descricao2',]
		]);
    	
    	$situacoes  = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['Situacoes.ativo'=>true]]);

    	
    	$count_situacoes = [];
    	
    	
    	foreach($situacoes as $id => $sit) {
    		$count_situacoes[$id]['Total'] = 0;
    		
    		foreach($agendamentos as $agendamento){
    			
    		}
    	}
    	
    	

    	
//     	$pdf = new \fpdf\FPDF();
    		
//     	$pdf->SetMargins(10,10,10);
//     	$pdf->AddPage();
//     	$pdf->SetFont('arial','',9);

    	
    	
//     		$pdf->Cell($width,6,$value,1,0,'L');
			
    	
    	
//     	$pdf->Output("relatorio.pdf","D");
    	
//     	$this->the_controller->response->type('pdf');
//     	$this->the_controller->viewBuilder()->layout('Base.pdf');
    	
    }
    public function relatorioAgendamentos($id = null)
    {
    	
    /*	$this->paginate = [
    			'contain' => ['Situacoes', 'Salas','Preceptor','CirurgiasProcedimentos.Procedimentos']
    	];*/
    	
//     	$preceptor = $this->Agendamentos->Medicos->find('list', ['conditions' => ['Medicos.ativo'=>true,'Medicos.preceptor'=>true],'order'=>'Medicos.nome']);
//     	$this->set('medicos', $preceptor);
    	 
//     	$situacoes = $this->Agendamentos->Situacoes->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
//     	$this->set('situacoes', $situacoes);
    	 
//     	$salas = $this->Agendamentos->Salas->find('list', ['conditions'=>['ativo'=>true],'order'=>'descricao']);
//     	$this->set('salas',$salas);
    	 
//     	$procedimentos = $this->Agendamentos->CirurgiasProcedimentos->Procedimentos->find('list', ['conditions' => ['Procedimentos.ativo'=>true],'order'=>'descricao']);
//     	$this->set('procedimentos',$procedimentos);
    	
    	//$vagas = $this->Agendamentos->Vagas->find('list', ['conditions' => ['Vagas.ativo'=>true],'order'=>'Vagas.descricao']);

    	$vagas = TableRegistry::get('mater.Vagas');
    	$vagas_list = $vagas->find('all')
    	->select([
    			'Vagas.data',
    			'Agendamentos.paciente_nome',
    			'Agendamentos.paciente_prontuario',
    			'Agendamentos.horario',
    			'Medicos.nome'
    	])
    	->leftJoin(
    			['Agendamentos' => 'mater.agendamentos'],
    			['Vagas.id = Agendamentos.vaga_id'])
    	->leftJoin(
    			['Medicos' => 'mater.medicos'],
    			['Agendamentos.medico_id = Medicos.id'])
    	->leftJoin(
    			['Salas' => 'mater.salas'],
    			['Agendamentos.sala_id = Salas.id'])
    	->leftJoin(
    			['Salas' => 'mater.salas'],
    			['Agendamentos.sala_id = Salas.id'])
    	->leftJoin(
    			['Situacoes' => 'mater.situacoes'],
    			['Agendamentos.situacao_id = Situacoes.id'])
    	->leftJoin(
    			['Solicitantes' => 'mater.medicos'],
    			['Agendamentos.solicitante_id = Situacoes.id']);

    	$this->set('vagas', $vagas_list);

    	

    	
    	$this->loadComponent('Base.PaginationSession', ['session'=>'paginatorAgendamentos']);
    	$this->PaginationSession->restore();
    	
    	$this->loadComponent('Base.Filter');
    	$this->Filter->addFilter([
    			'data_inicio'=> ['field'=> 'Agendamentos.data', 'operator'=>'>='],
    			'data_fim'=> ['field'=> 'Agendamentos.data', 'operator'=>'<='],
    			'situacao_id'=> ['field'=> 'Agendamentos.situacao_id', 'operator'=>'IN'],
    			'sala_id'=> ['field'=> 'Agendamentos.sala_id', 'operator'=>'IN'],
    			'medico_id'=> ['field'=> 'Agendamentos.medico_id', 'operator'=>'IN'],
    			'procedimento_id'=> ['field'=> 'Procedimentos.id', 'operator'=>'='],
    			'paciente_prontuario'=> ['field'=> 'Agendamentos.paciente_prontuario', 'operator'=>'ILIKE'],
    			'paciente_nome'=> ['field'=> 'Agendamentos.paciente_nome', 'operator'=>'ILIKE'],
    	]);
    	 
    	$conditions = $this->Filter->getConditions(['session'=>'filterAgendamentos']);
    	$this->set('url', $this->Filter->getUrl());
    	 
    	
    	 
    	 
    	if(!isset($this->request->query['limit']))
    		$this->paginate['limit'] = 15;
    	
    		if(!isset($this->request->query['order']))
    			$this->paginate['order'] = ['Agendamentos.data DESC'];
    	
    	
    			$procedimento_id = null;
    			if(isset($conditions['Procedimentos.id'])){
    				$procedimento_id = $conditions['Procedimentos.id'];
    				unset($conditions['Procedimentos.id']);
    			}
    			 
    			$this->paginate['conditions']	= $conditions;
    			 
    			//     	debug($this->paginate); exit;
    			 
    			$query = $this->Agendamentos->find('all', $this->paginate);
    			 
    			if($procedimento_id){
    				$query->matching('CirurgiasProcedimentos', function ($q) use ($procedimento_id) {
    					return $q->where(['CirurgiasProcedimentos.procedimento_id IN' => $procedimento_id ]);
    				});
    					 
    			}
    			 
    			// Export CSV
    			if(isset($this->request->query['export']) && $this->request->query['export']=='csv'){
    				$this->loadComponent('Base.Export');
    				//     		$data_export = $this->Agendamentos->find('all', ['conditions'=> $conditions  ,'contain' => ['Periodos', 'Situacoes', 'Salas']   ]);
    				$query->limit();
    				$callback = function ($object){
    					$procs = [];
    					foreach ($object->cirurgias_procedimentos as $p){
    						$procs[] = $p->procedimento->descricao2;
    					}
    					$procs = implode(', ', $procs);
    					return [$object->data->format('d/m/Y'),$object->horario->format('H:i'),$object->sala->descricao,$object->preceptor->nome,$object->paciente_prontuario,$object->paciente_nome,$procs,$object->material_especial,$object->situacao->descricao,];
    				};
    				$this->Export->CSV('Mapa_'.date('d_m_Y').'.csv', $query, ['Data','Hora','Sala','Médico','Prontuário','Paciente','Procedimentos','Material_Especial','Situação'], $callback );
    			}
    			 
    			$this->set('agendamentos', $query );
    			$this->paginate($this->Agendamentos);
    			$this->set('_serialize', ['agendamentos']);
    	
    			$this->PaginationSession->save();
    	
    }
    
}
