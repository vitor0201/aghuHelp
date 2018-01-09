<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bloqueio Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $data
 * @property string $justificativa
 * @property string $usuario_cadastro
 * @property string $data_cadastro
 * @property int $medico_id
 * @property \Mater\Model\Entity\Medico $medico
 */
class Bloqueio extends Entity
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
