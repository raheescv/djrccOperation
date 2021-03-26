<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSituationViewsTable extends Migration
{
  public function up()
  {
    \DB::statement("DROP VIEW IF EXISTS situation_views;");
    \DB::statement("CREATE VIEW situation_views AS
      SELECT
      A.id,
      A.beacon_id,
      B.beacon_type_id,
      B.hex_no as Beacon,
      A.country_id,
      C.name as Country,
      A.registered,
      A.opened_by,
      D.name as OpenedBy,
      A.closed_by,
      E.name as ClosedBy
      FROM `situations`      AS A
      INNER JOIN `beacons`   AS B ON B.id = A.beacon_id
      INNER JOIN `countries` AS C ON C.id = A.country_id
      INNER JOIN `employees` AS D ON D.id = A.opened_by
      INNER JOIN `employees` AS E ON E.id = A.closed_by
      "
    );
  }
  public function down()
  {
    \DB::statement("DROP VIEW IF EXISTS situation_views;");
  }
}
