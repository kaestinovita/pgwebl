<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'point';
    protected $guarded = ['id'];

    public function geojson_points()
    {
        $points = DB::table('point')
            ->select(DB::raw('
                point.id,
                ST_AsGeoJSON(point.geom) as geom,
                point.name,
                point.description,
                point.image,
                point.created_at,
                point.updated_at,
                point.user_id,
                users.name as user_created
            '))
            ->leftJoin('users', 'point.user_id', '=', 'users.id')
            ->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
                    'image' => $p->image,
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

     public function geojson_point($id)
    {
        $points = $this
        ->select(DB::raw('id, st_asgeojson(geom) as geom, name, description, image, created_at, updated_at'))
        ->where('id', $id)
        ->get();

        $geojson = [
            'type'=> 'FeatureCollection',
            'features' => [],
        ];

        foreach ($points as $p) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($p->geom),
                'properties' => [
                    'id' => $p->id,
                    'name' => $p->name,
                    'description' => $p->description,
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
