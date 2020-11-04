<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Settings extends Model
{
  protected $guarded = [];
  public $rules = [
    'collapse_menu'   => 'required',
    'fixed_nav_bar'   => 'required',
    'fixed_side_bar'  => 'required',
    'fixed_footer'    => 'required',
    'skin'            => 'required',
  ];
}
