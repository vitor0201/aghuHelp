<?php
namespace Base\Model\Entity;

use Cake\ORM\Entity;

/**
 * Acao Entity.
 *
 * @property int $id
 * @property int $sistema_id
 * @property \App\Model\Entity\Sistema $sistema
 * @property string $prefix
 * @property string $action
 * @property string $controller
 * @property bool $ativo
 * @property string $tipo
 * @property \App\Model\Entity\Grupo[] $grupos
 */
class Acao extends Entity
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
