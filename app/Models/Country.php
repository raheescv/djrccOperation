<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Country extends Model
{
  use HasFactory;
  public static function countryOptions() {
    return [
      '1'=>"India",
      '2'=>"Qatar",
      '3'=>"US",
    ];
  }
}
