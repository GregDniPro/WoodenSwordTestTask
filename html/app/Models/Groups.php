<?php declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class Groups
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $label
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Groups newModelQuery()
 * @method static Builder|Groups newQuery()
 * @method static Builder|Groups query()
 * @method static Builder|Groups whereCreatedAt($value)
 * @method static Builder|Groups whereId($value)
 * @method static Builder|Groups whereLabel($value)
 * @method static Builder|Groups whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Groups extends Model
{
    use HasTimestamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['label'];
}
