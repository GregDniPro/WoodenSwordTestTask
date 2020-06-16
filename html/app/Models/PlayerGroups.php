<?php declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlayerGroups
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $player_id
 * @property int $group_id
 * @method static Builder|PlayerGroups newModelQuery()
 * @method static Builder|PlayerGroups newQuery()
 * @method static Builder|PlayerGroups query()
 * @method static Builder|PlayerGroups whereGroupId($value)
 * @method static Builder|PlayerGroups whereId($value)
 * @method static Builder|PlayerGroups wherePlayerId($value)
 * @mixin Eloquent
 */
class PlayerGroups extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['player_id', 'group_id'];
}
