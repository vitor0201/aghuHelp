<?php

namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\Criterio;

/**
 * Criterios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Especialidades
 * @property \Cake\ORM\Association\BelongsTo $Unidades
 */
class CriteriosTable extends Table {
	
	/**
	 * Initialize method
	 *
	 * @param array $config
	 *        	The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize ( $config );
		
		$this->table ( 'kanban.criterios' );
		$this->displayField ( 'id' );
		$this->primaryKey ( 'id' );
		
		/*
		 * $this->belongsTo('Especialidades', [
		 * 'foreignKey' => 'especialidade_id',
		 * 'className' => 'Indicadores.Especialidades'
		 * ]);
		 * $this->belongsTo('Unidades', [
		 * 'foreignKey' => 'unidade_id',
		 * 'className' => 'Indicadores.Unidades'
		 * ]);
		 */
	}
	
	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator
	 *        	Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator->add ( 'id', 'valid', [ 
				'rule' => 'numeric' 
		] )->allowEmpty ( 'id', 'create' );
		
		$validator->requirePresence ( 'inicio', 'create', [ 
				'rule' => 'numeric' 
		] )->notEmpty ( 'inicio', 'Campo obrigatório' );
		
		$validator->requirePresence ( 'fim', 'create', [ 
				'rule' => 'numeric' 
		] )->notEmpty ( 'fim', 'Campo obrigatório.' );
		
		$validator->requirePresence ( 'cor', array (
				'custom',
				'/[#]{1}[a-fA-F0-9]{6}/' 
		) )->notEmpty ( 'cor', 'Campo obrigatório.' );
		$validator->requirePresence('movimento_id')
		->notEmpty('movimento_id', 'Campo Obrigatório');
		
		return $validator;
	}

/**
 * Returns a rules checker object that will be used for validating
 * application integrity.
 *
 * @param \Cake\ORM\RulesChecker $rules
 *        	The rules object to be modified.
 * @return \Cake\ORM\RulesChecker
 */
	/*
	 * public function buildRules(RulesChecker $rules)
	 * {
	 * $rules->add($rules->existsIn(['especialidade_id'], 'Especialidades'));
	 * $rules->add($rules->existsIn(['unidade_id'], 'Unidades'));
	 * return $rules;
	 * }
	 */
}
