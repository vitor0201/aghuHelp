<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * CirurgiasProcedimento Entity.
 *
 * @property int $id
 * @property int $cirurgia_id
 * @property \Mater\Model\Entity\Agendamento $agendamento
 * @property int $procedimento_id
 * @property \Mater\Model\Entity\Procedimento $procedimento
 * @property int $resultado_id
 * @property \Mater\Model\Entity\Resultado $resultado
 * @property string $observacao
 */
class CirurgiasProcedimento extends Entity
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
