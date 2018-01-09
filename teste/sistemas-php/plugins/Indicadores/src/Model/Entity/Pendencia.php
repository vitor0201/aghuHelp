<?php
namespace Indicadores\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pendencia Entity.
 *
 * @property int $id
 * @property int $tipo_pendencia_id
 * @property \Indicadores\Model\Entity\TipoPendencia $tipo_pendencia
 * @property string $observacao
 * @property int $usuario_id
 * @property \Indicadores\Model\Entity\Usuario $usuario
 * @property \Cake\I18n\Time $data_remocao
 * @property int $observacao_remocao
 * @property \Cake\I18n\Time $data_cadastro
 * @property int $remocao_usuario_id
 * @property \Indicadores\Model\Entity\RemocaoUsuario $remocao_usuario
 */
class Pendencia extends Entity
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
