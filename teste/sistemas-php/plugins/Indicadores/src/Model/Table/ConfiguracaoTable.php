<?php

namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\Configuracao;

/**
 * Configuracao Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Indicadores
 */
class ConfiguracaoTable extends Table {
	
	/**
	 * Initialize method
	 *
	 * @param array $config
	 *        	The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize ( $config );
		
		$this->table ( 'kanban.configuracao' );
		$this->displayField ( 'id' );
		$this->primaryKey ( 'id' );
		
		$this->belongsTo ( 'Indicadores', [ 
				'foreignKey' => 'indicador_id',
				'joinType' => 'INNER',
				'className' => 'Indicadores.Indicadores' 
		] );
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
		], 'Usuario incorreto' )->allowEmpty ( 'id', 'create' );
		
		$validator->requirePresence ( 'data', 'create', 'Campo Obrigatório' )->notEmpty ( 'data', 'create', 'Campo obrigatório' );
		
		$validator->add ( 'valor', 'valid', [ 
				'rule' => 'decimal' 
		] )->requirePresence ( 'valor', 'create' )->notEmpty ( 'valor', 'Campo obrigatório.' );
		
		$validator->add ('ativo');
		
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
	public function buildRules(RulesChecker $rules) {
		$rules->add ( $rules->existsIn ( [ 
				'indicador_id' 
		], 'Indicadores' ) );
		return $rules;
	}
}
