<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolygonsModel extends Model
{
    protected $table = 'polygon';
    protected $guarded = ['id'];

    public function geojson_polygons()
    {
        // Ambil data polygon lengkap dengan nama user
        $polygons = DB::table('polygon') // sesuaikan nama tabel jika 'polygons'
            ->select(DB::raw('
                polygon.id,
                ST_AsGeoJSON(polygon.geom) as geom,
                polygon.name,
                polygon.description,
                polygon.image,
                ST_Area(polygon.geom, true) as area_m2,
                ST_Area(polygon.geom, true)/10000 as area_hektar,
                ST_Area(polygon.geom, true)/1000000 as area_km2,
                polygon.created_at,
                polygon.updated_at,
                polygon.user_id,
                users.name as user_created
            '))
            ->leftJoin('users', 'polygon.user_id', '=', 'users.id')
            ->get();

        // Bentuk struktur GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'area_m2' => $p->area_m2,
                    'area_hektar' => $p->area_hektar,
                    'area_km2' => $p->area_km2,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'user_id' => $p->user_id,
                    'user_created' => $p->user_created,
                ],
            ];
               array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
    public function geojson_polygon($id)
    {
        $polygons = $this
            ->select(DB::raw('id, st_asgeojson(geom) as geom, st_area(geom, true) as luas_m2, st_area(geom, true)/1000000 as luas_km2, st_area(geom, true)/10000 as luas_hektar, name, description, image, created_at, updated_at'))
            ->where('id', $id)
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polygons as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'area_m2' => $p->luas_m2,
                    'area_km2' => $p->luas_km2,
                    'area_hektar' => $p->luas_hektar,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'image' => $p->image,
                ],
            ];

            array_push($geojson['features'], $feature);
        }
        return $geojson;
    }
}
