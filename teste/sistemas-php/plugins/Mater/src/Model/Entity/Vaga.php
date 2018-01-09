<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vaga Entity.
 *
 * @property int $id
 * @property int $sala_id
 * @property \Mater\Model\Entity\Sala $sala
 * @property \Cake\I18n\Time $data
 * @property \Cake\I18n\Time $horario
 * @property \Cake\I18n\Time $data_cadastro
 * @property string $usuario_cadastro
 * @property \Mater\Model\Entity\Agendamento[] $agendamentos
 */
class Vaga extends Entity
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
