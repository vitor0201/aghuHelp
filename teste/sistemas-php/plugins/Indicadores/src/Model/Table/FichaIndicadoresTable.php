<?php

namespace Indicadores\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Indicadores\Model\Entity\FichaIndicador;

/**
 * FichaIndicadores Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Indicadores
 */
class FichaIndicadoresTable extends Table {
	
	/**
	 * Initialize method
	 *
	 * @param array $config
	 *        	The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize ( $config );
		
		$this->table ( 'kanban.ficha_indicadores' );
		$this->displayField ( 'id' );
		$this->primaryKey ( 'id' );
		
		$this->belongsTo ( 'kanban.Indicadores', [ 
				'foreignKey' => 'indicador_id',
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
		] )->allowEmpty ( 'id', 'create' );
		$validator->requirePresence ( 'formula', 'create' )->notEmpty ( 'formula', 'Campo obrigatório.' );
		
		$validator->requirePresence ( 'eixo', 'create' )->notEmpty ( 'eixo', 'Campo obrigatório.' );
		$validator->requirePresence ( 'nivel', 'create' )->notEmpty ( 'nivel', 'Campo obrigatório.' );
		$validator->requirePresence ( 'objetivo', 'create' )->notEmpty ( 'objetivo', 'Campo obrigatório.' );
		$validator->requirePresence ( 'finalidade', 'create' )->notEmpty ( 'finalidade', 'Campo obrigatório.' );
		$validator->requirePresence ( 'historico', 'create' )->notEmpty ( 'historico', 'Campo obrigatório.' );
		
		$validator->requirePresence ( 'formula', 'create' )->notEmpty ( 'formula', 'Campo obrigatório.' );
		$validator->requirePresence ( 'homologacao', 'create' )->notEmpty ( 'homologacao', 'Campo obrigatório.' );
		$validator->requirePresence ( 'identificador', 'create' )->notEmpty ( 'identificador', 'Campo obrigatório.' );
		$validator->requirePresence ( 'tipo', 'create' )->notEmpty ( 'tipo', 'Campo obrigatório.' );
		$validator->requirePresence ( 'termos', 'create' )->notEmpty ( 'termos', 'Campo obrigatório.' );
		$validator->requirePresence ( 'fonte', 'create' )->notEmpty ( 'fonte', 'Campo obrigatório.' );
		$validator->requirePresence ( 'responsavel', 'create' )->notEmpty ( 'responsavel', 'Campo obrigatório.' );
		$validator->requirePresence ( 'telefone', 'create' )->notEmpty ( 'telefone', 'Campo obrigatório.' );
		
		$validator->add ( 'email', 'valid', [ 
				'rule' => 'email' 
		] )->allowEmpty ( 'email' );
		$validator->requirePresence ( 'periocidade', 'create' )->notEmpty ( 'periocidade', 'Campo obrigatório.' );
		$validator->requirePresence ( 'parametro', 'create' )->notEmpty ( 'parametro', 'Campo obrigatório.' );
		$validator->requirePresence ( 'tipo', 'create' )->notEmpty ( 'tipo', 'Campo obrigatório.' );
		$validator->requirePresence ( 'area', 'create' )->notEmpty ( 'area', 'Campo obrigatório.' );
		
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
		$rules->add ( $rules->isUnique ( [ 
				'indicador_id' 
		], 'Valor já cadastrado' ) );
		$rules->add ( $rules->existsIn ( [ 
				'indicador_id' 
		], 'Indicadores' ) );
		return $rules;
	}
}
