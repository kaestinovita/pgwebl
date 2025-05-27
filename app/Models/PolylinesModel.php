<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PolylinesModel extends Model
{
    protected $table = 'polylines';
    //otomatis
    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        // Ambil data dari database
       $polylines = DB::table('polylines')
    ->select(DB::raw('
        polylines.id,
        ST_AsGeoJSON(polylines.geom) as geom,
        polylines.name,
        polylines.description,
        polylines.image,
        ST_Length(polylines.geom, true) as length_m,
        ST_Length(polylines.geom, true) / 1000 as length_km,
        polylines.created_at,
        polylines.updated_at,
        polylines.user_id,
        users.name as user_created
    '))
    ->leftJoin('users', 'polylines.user_id', '=', 'users.id')
    ->get();


        // Bangun struktur GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'length_m' => $p->length_m,
                    'length_km' => $p->length_km,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                    'user_id' => $p->user_id,
                    'user_created' => $p->user_created,
                ],
            ];

            $geojson['features'][] = $feature;
        }

        // Kembalikan GeoJSON
        return $geojson;
    }
    public function geojson_polyline($id)
    {
        // Ambil data dari database
        $polylines = $this
            ->select(DB::raw('id,st_asgeojson(geom) as geom, name, description, image, st_length(geom, true) as length_m, st_length(geom, true) / 1000 as length_km, created_at, updated_at'))
            ->where('id', $id)
            ->get();

        // Bangun struktur GeoJSON
        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($polylines as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
                    'length_m' => $p->length_m,
                    'length_km' => $p->length_km,
                    'created_at' => $p->created_at,
                    'updated_at' => $p->updated_at,
                ],
            ];

            $geojson['features'][] = $feature;
        }

        // Kembalikan GeoJSON
        return $geojson;
    }
}
