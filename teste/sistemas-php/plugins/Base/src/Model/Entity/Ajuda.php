<?php
namespace Base\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ajuda Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $conteudo
 * @property int $lft
 * @property int $rght
 * @property int $parent_id
 * @property \App\Model\Entity\ParentAjuda $parent_ajuda
 * @property bool $ativo
 * @property int $sistema_id
 * @property \App\Model\Entity\Sistema $sistema
 * @property \App\Model\Entity\ChildAjuda[] $child_ajudas
 */
class Ajuda extends Entity
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
