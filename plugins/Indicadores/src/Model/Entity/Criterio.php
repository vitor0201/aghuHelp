<?php
namespace Indicadores\Model\Entity;

use Cake\ORM\Entity;

/**
 * Criterio Entity.
 *
 * @property int $id
 * @property int $inicio
 * @property int $fim
 * @property string $cor
 * @property int $especialidade_id
 * @property \Indicadores\Model\Entity\Especialidade $especialidade
 * @property int $unidade_id
 * @property \Indicadores\Model\Entity\Unidade $unidade
 */
class Criterio extends Entity
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
