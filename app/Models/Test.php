<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
//    use HasFactory;

    protected $fillable = [
        'time_limit',
        'total_questions',
        'is_active',
    ];

//    // 🔗 Relationships
//
//    // One Test → Many Questions
//    public function questions()
//    {
//        return $this->hasMany(Question::class);
//    }
//
//    // 👤 Optional: who created the test
//    public function creator()
//    {
//        return $this->belongsTo(User::class, 'created_by');
//    }
//
//    // ⚡ Scopes (very useful)
//
//    // Only active tests
//    public function scopeActive($query)
//    {
//        return $query->where('is_active', true);
//    }
}
