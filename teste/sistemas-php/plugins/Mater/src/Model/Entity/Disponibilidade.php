<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Disponibilidade Entity.
 *
 * @property int $id
 * @property int $medico_id
 * @property \Mater\Model\Entity\Medico $medico
 * @property int $dia_semana
 * @property int $periodo_id
 * @property \Mater\Model\Entity\Periodo $periodo
 * @property bool $ativo
 */
class Disponibilidade extends Entity
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
