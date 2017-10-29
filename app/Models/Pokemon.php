<?php

namespace App\Models;

use App\Library\Database\PokemonProfilesContract;

/**
 * App\Models\Pokemon
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property int $height
 * @property int $weight
 * @property int $base_experience
 * @property mixed $attributes
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereBaseExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pokemon whereWeight($value)
 */
class Pokemon extends \Eloquent
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = PokemonProfilesContract::TABLE_NAME;
}
