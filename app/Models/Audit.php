<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Audit extends Model
{
    protected $guarded = [];
    protected $dates = [
        'created_at',
    ];
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];
    protected $data = [];
    public function User() {
  		return $this->belongsTo(User::class,'user_id');
    }
    public function AuditableType()
    {
      $explode=explode("\\",$this->auditable_type);
      return $explode[2];
    }
}
