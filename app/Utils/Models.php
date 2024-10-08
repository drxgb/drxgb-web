<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Relation;


/**
 * Contém funções utilitárias para modelos.
 *
 * @author Dr.XGB <https://github.com/drxgb>
 * @version 1.0.0
 */
abstract class Models
{
	/**
	 * Recebe o atributo ou o relacionamento de um modelo.
	 *
	 * @param Relation $relation
	 * @param bool $useRelation
	 * @return Attribute|Relation
	 */
	public static function getAttributeOrRelation(Relation $relation, bool $useRelation) : Attribute|Relation
	{
		return $useRelation
			? $relation
			: Attribute::get(fn () => $relation->get());
	}
}
