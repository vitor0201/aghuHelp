<?php
namespace Indicadores\Model\Entity;

use Cake\ORM\Entity;

/**
 * Configuracao Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $data
 * @property float $valor
 * @property int $indicador_id
 * @property \Indicadores\Model\Entity\Indicador $indicador
 */
class Configuracao extends Entity
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
