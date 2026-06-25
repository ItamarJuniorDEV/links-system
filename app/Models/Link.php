<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method bool|null delete()
 */
class Link extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    private function move($to)
    {
        $order = $this->sort;
        $newOrder = $order + $to;

        $swapWith = $this->user->links()->where('sort', '=', $newOrder)->first();
        if (! $swapWith) {
            return;
        }

        $swapWith->fill(['sort' => $order])->save();
        $this->fill(['sort' => $newOrder])->save();
    }

    public function moveUp()
    {
        $this->move(-1);
    }

    public function moveDown()
    {
        $this->move(+1);
    }
}
