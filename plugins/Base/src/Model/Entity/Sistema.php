<?php
namespace Base\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sistema Entity.
 *
 * @property int $id
 * @property string $nome
 * @property bool $ativo
 * @property \Cake\I18n\Time $criado_em
 * @property \Cake\I18n\Time $atualizado_em
 * @property string $versao
 * @property \App\Model\Entity\Acao[] $acoes
 * @property \App\Model\Entity\Ajuda[] $ajudas
 * @property \App\Model\Entity\Grupo[] $grupos
 * @property \App\Model\Entity\Menu[] $menus
 * @property \App\Model\Entity\Parametro[] $parametros
 * @property \App\Model\Entity\Usuario[] $usuarios
 */
class Sistema extends Entity
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
