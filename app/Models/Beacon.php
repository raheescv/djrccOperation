<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Beacon extends Model {
  use HasFactory;
  use SoftDeletes;
  const NEWBEACON  = 1;
  const TESTBEACON = 2;
  protected $fillable = [
    "hex_no",
    "beacon_type_id",
    "country_id",
    "password",
    "security_question",
    "security_answer",
    "special_status",
    "description",
    "name",
    "address",
    "city",
    "state",
    "postal_code",
    "email",
    "telephone",
    "mobile",
    "vehicle_type_id",
    "radio_equipment",
    "color",
    "air_craft_manufacturer",
    "air_craft_operation_agency",
    "specific_usage",
    "additional_usage",
    "vessel_name",
    "no_of_life_boats",
    "no_of_life_rafts",
    "radio_call_sign",
    "radio_call_sign_decode",
    "inmarsat",
    "vessel_cellular",
    "manufacturer",
    "model_no",
    "c_s_type_approval_no",
    "activation_method",
    "beacon_home_device",
    "additional_information",
    "primary_name",
    "primary_address_line_1",
    "primary_address_line_2",
    "primary_phone_number_1",
    "primary_phone_number_2",
    "primary_phone_number_3",
    "primary_phone_number_4",
    "alternative_name",
    "alternative_address_line_1",
    "alternative_address_line_2",
    "alternative_phone_number_1",
    "alternative_phone_number_2",
    "alternative_phone_number_3",
    "alternative_phone_number_4",
    "created_by",
    "updated_by",
    "status",
  ];
  public static function rules ($id=0, $merge=[]) {
    return array_merge([
      'hex_no'         => 'required|unique:beacons'. ($id ? ",hex_no,$id" : ''),
      'beacon_type_id' => 'required',
    ],
    $merge);
  }
  public static function typeOptions() {
    return [
      'ELT'=>"ELT",
      'EPIRB'=>"EPIRB",
      'PLB'=>"PLB",
    ];
  }
  public function Country() {
    return $this->belongsTo(Country::class);
  }
  public static function securityQuestionOptions() {
    return [
      'What Is the Name Of Your Favorite Movie'=>"What Is the Name Of Your Favorite Movie",
      'What Is Your Nick Name'=>"What Is Your Nick Name",
      'What Is Your Mothers Name'=>"What Is Your Mothers Name",
      'What Is Your Fathers Name'=>"What Is Your Fathers Name",
    ];
  }
  public static function specialStatusOptions() {
    return [
      'status_1'=>"status_1",
      'status_2'=>"status_2",
      'status_3'=>"status_3",
      'status_4'=>"status_4",
    ];
  }
  public static function manufacturerOptions() {
    return [
      'ACR Electronics'=>"ACR Electronics",
      'DCR Electronics'=>"DCR Electronics",
    ];
  }
  public static function activationMethodOptions() {
    return [
      'Category 1 Automatic or Manual'=>"Category 1 Automatic or Manual",
      'Category 2 Automatic and Manual'=>"Category 2 Automatic and Manual",
      'Category 3 Automatic'=>"Category 3 Automatic",
      'Category 4 Manual'=>"Category 4 Manual",
    ];
  }
  public static function beaconHomeDeviceOptions() {
    return [
      'SART'=>"SART",
      'Devices 2'=>"Devices 2",
      'Devices 3'=>"Devices 3",
    ];
  }
  public static function radioEquipmentOptions() {
    return [
      "HF"=>"HF",
      "MF"=>"MF",
      "SSB"=>"SSB",
      "VHF"=>"VHF",
      "Other"=>"Other",
    ];
  }
  public static function vehicleTypeOptions() {
    return [
      "Multiple Engin Jet"=>"Multiple Engin Jet",
      "Power Tug"=>"Power Tug",
      "Boat"=>"Boat",
    ];
  }
  public function selfCreate($data) {
    try {
      $data['created_by']=Auth::user()->id;
      $data['updated_by']=$data['created_by'];
      $validator = \Validator::make($data,$this->rules());
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
      $Self=Self::create($data);
      $return['id']=$Self->id;
      $return['status']=$Self->status;
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
  public function selfUpdate($data,$id) {
    try {
      $data['updated_by']=Auth::user()->id;
      $validator = \Validator::make($data,$this->rules($id));
      if($validator->fails())  { foreach ($validator->errors()->getMessages() as $key => $value) { throw new \Exception($value[0]); } }
      $Self=Self::find($id);
      $Self->update($data);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
  public function selfDelete($id) {
    try {
      $Self=Self::find($id);
      if(!$Self->delete()) throw new \Exception("Cant Delete This Beacon". $id, 1);
      $return['result']='success';
    } catch (\Exception $e) {
      $return['result']=$e->getMessage();;
    }
    return $return;
  }
}
