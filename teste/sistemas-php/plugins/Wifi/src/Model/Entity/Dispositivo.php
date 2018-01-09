<?php
namespace Wifi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dispositivo Entity.
 *
 * @property int $id
 * @property int $tipo_dispositivo_id
 * @property \Wifi\Model\Entity\TipoDispositivo $tipo_dispositivo
 * @property int $internauta_id
 * @property \Wifi\Model\Entity\Internauta $internauta
 * @property int $situacao_id
 * @property \Wifi\Model\Entity\Situacao $situacao
 * @property string $endereco_mac
 * @property string $justificativa
 * @property \Cake\I18n\Time $data_cadastro
 * @property \Cake\I18n\Time $data_recebimento
 * @property string $endereco_ip
 */
class Dispositivo extends Entity
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
