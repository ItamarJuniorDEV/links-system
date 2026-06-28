<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    private function move($direction)
    {
        $neighbor = $direction < 0
            ? $this->user->links()->where('sort', '<', $this->sort)->orderByDesc('sort')->first()
            : $this->user->links()->where('sort', '>', $this->sort)->orderBy('sort')->first();

        if (! $neighbor) {
            return;
        }

        $sort = $this->sort;
        $this->sort = $neighbor->sort;
        $neighbor->sort = $sort;

        $this->save();
        $neighbor->save();
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
