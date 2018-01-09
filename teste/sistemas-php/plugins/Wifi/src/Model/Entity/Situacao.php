<?php
namespace Wifi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Situacao Entity.
 *
 * @property int $id
 * @property string $descricao
 * @property \Wifi\Model\Entity\Dispositivo[] $dispositivos
 */
class Situacao extends Entity
{

	public static $REMOVIDO_ID = 4;
	public static $ATIVO_ID = 3;
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
