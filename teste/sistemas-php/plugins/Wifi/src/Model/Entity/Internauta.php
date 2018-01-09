<?php
namespace Wifi\Model\Entity;

use Cake\ORM\Entity;

/**
 * Internauta Entity.
 *
 * @property int $id
 * @property string $nome
 * @property string $cpf
 * @property \Cake\I18n\Time $data_nascimento
 * @property string $setor
 * @property string $email
 * @property string $contato
 * @property \Cake\I18n\Time $data_cadastro
 * @property \Cake\I18n\Time $data_atualizacao
 * @property string $login
 * @property \Wifi\Model\Entity\Dispositivo[] $dispositivos
 */
class Internauta extends Entity
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
