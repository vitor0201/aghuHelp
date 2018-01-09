<?php
namespace Sms\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mensagem Entity.
 *
 * @property int $id
 * @property int $ddd
 * @property int $fone
 * @property string $texto
 * @property \Cake\I18n\Time $data_hora
 * @property string $status
 * @property string $login
 */
class Mensagem extends Entity
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
