<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    // Ensure timestamps are enabled
    public $timestamps = true;

    protected $fillable = [
        'black', 'white', 'winner', 'moves'
    ];

    // Cast created_at and updated_at to Carbon instances
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}