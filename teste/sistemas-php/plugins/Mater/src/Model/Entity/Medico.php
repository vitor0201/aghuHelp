<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Medico Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $crm
 * @property bool $residente
 * @property bool $preceptor
 * @property int $ativo
 * @property \Mater\Model\Entity\CirurgiasMedico[] $cirurgias_medicos
 * @property \Mater\Model\Entity\Disponibilidade[] $disponibilidades
 * @property \Mater\Model\Entity\Procedimento[] $procedimentos
 */
class Medico extends Entity
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
