<?php
namespace Base\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cargo Entity.
 *
 * @property int $id
 * @property string $cargo_descricao
 * @property string $cargo_codigo
 * @property string $cargo_observacao
 * @property \App\Model\Entity\Funcionario[] $funcionario
 */
class Cargo extends Entity
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
