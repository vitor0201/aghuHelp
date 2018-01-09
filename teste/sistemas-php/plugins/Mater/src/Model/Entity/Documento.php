<?php
namespace Mater\Model\Entity;

use Cake\ORM\Entity;

/**
 * Documento Entity.
 *
 * @property int $id
 * @property int $procedimento_id
 * @property \Mater\Model\Entity\Procedimento $procedimento
 * @property bool $ativo
 * @property string $titulo
 * @property \Cake\I18n\Time $cadastro
 * @property string $usuario_cadastro
 * @property string|resource $arquivo
 * @property int $arquivo_tamanho
 * @property string $arquivo_tipo
 * @property string $arquivo_nome
 */
class Documento extends Entity
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
