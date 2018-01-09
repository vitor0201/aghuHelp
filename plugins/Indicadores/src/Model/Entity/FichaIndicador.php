<?php
namespace Indicadores\Model\Entity;

use Cake\ORM\Entity;

/**
 * FichaIndicador Entity.
 *
 * @property int $id
 * @property string $area
 * @property string $eixo
 * @property string $nivel
 * @property string $objetivo
 * @property string $finalidade
 * @property string $historico
 * @property string $formula
 * @property int $indicador_id
 * @property \Indicadores\Model\Entity\Indicador $indicador
 * @property string $homologacao
 * @property string $identificador
 * @property string $tipo
 * @property string $termos
 * @property string $fonte
 * @property string $responsavel
 * @property string $telefone
 * @property string $email
 * @property string $periocidade
 * @property int $estilo_id
 * @property \Indicadores\Model\Entity\Estilo $estilo
 */
class FichaIndicador extends Entity
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
