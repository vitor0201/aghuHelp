<?php
namespace Wifi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coleta Entity.
 *
 * @property int $id
 * @property string $codigo
 * @property string $descricao
 * @property \Cake\I18n\Time $validate
 * @property string $lote
 * @property float $quantidade
 */
class Coleta extends Entity
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
