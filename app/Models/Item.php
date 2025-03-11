<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $fillable = ['name', 'detail', 'status', 'checklist_id'];

    protected $casts = [
        'status' => 'boolean',
    ];
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
