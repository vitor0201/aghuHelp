<?php
namespace Tutorial\Model\Entity;

use Cake\ORM\Entity;

/**
 * Arquivo Entity.
 *
 * @property int $id
 * @property int $categoria_id
 * @property \Tutorial\Model\Entity\Categoria $categoria
 * @property string $titulo
 * @property string $autor
 * @property string $descricao
 * @property bool $ativo
 * @property string $arquivo_caminho
 * @property int $arquivo_tamanho
 * @property string $arquivo_type
 * @property \Cake\I18n\Time $data_publicacao
 * @property \Tutorial\Model\Entity\Tag[] $tags
 */
class Arquivo extends Entity
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
