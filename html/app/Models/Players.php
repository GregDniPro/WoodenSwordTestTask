<?php declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Players
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $display_name
 * @property int $group_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Players newModelQuery()
 * @method static Builder|Players newQuery()
 * @method static Builder|Players query()
 * @method static Builder|Players whereCreatedAt($value)
 * @method static Builder|Players whereDisplayName($value)
 * @method static Builder|Players whereId($value)
 * @method static Builder|Players whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Players extends Model
{
    use HasTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['display_name', 'group_id'];
}
