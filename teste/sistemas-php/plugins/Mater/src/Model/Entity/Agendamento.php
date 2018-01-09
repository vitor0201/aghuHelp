<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Agendamento Entity.
 *
 * @property int $id
 * @property int $periodo_id
 * @property \Mater\Model\Entity\Periodo $periodo
 * @property int $situacao_id
 * @property \Mater\Model\Entity\Situacao $situacao
 * @property int $sala_id
 * @property \Mater\Model\Entity\Sala $sala
 * @property \Cake\I18n\Time $data_cadastro
 * @property \Cake\I18n\Time $data
 * @property string $dia_semana
 * @property string $sequencia
 * @property \Cake\I18n\Time $horario
 * @property \Cake\I18n\Time $duracao
 * @property string $paciente_prontuario
 * @property string $prontuario
 * @property string $paciente_nome
 * @property string $paciente_fone1
 * @property string $paciente_fone2
 * @property string $paciente_nascimento
 * @property string $aih
 * @property string $observacao
 */
class Agendamento extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
