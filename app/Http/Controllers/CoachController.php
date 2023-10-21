<?php

namespace App\Http\Controllers;

use App\Models\Bootcamp;
use App\Models\Coach;
use App\Models\Detalle_Bootcamp_Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(){
        //select * from table => all()
        /**
         * validar que solo estan coaches con estado 1 (activos)
         * seleccionar el nombre de la materia
         */
        //$coaches = Coach::all();
        $coaches = Coach::join('materia','coach.id_materia','=','materia.id')->where('coach.id_estado','=',1)->select('coach.*','materia.nombre AS materia')->get();
        //json

        /**
         * json_encode => convierte un arreglo en JSON
         * json_decode => convierte un JSON en arreglo
         * 200 => exito / ok
         * 404 => no encontro el objeto
         * 500 => servidor error
         */
        return response()->json(["status" => 200, "detalle" => $coaches]);
    }

    //registrar un coach
    public function store(Request $request){
        //creamos un arreglos para los datos del coach
        $datos = array(
            "nombre" => $request->input('nombre'), //yaneth
            "apellido" => $request->input('apellido'),
            "telefono" => $request->input('telefono'),
            "correo" => $request->input('correo'),
            "password" => $request->input('password'),
            "id_materia" => $request->input('id_materia')
        );

        if(!empty($datos)){
            //insert into table ... => save()
            $coach = new Coach();
            $coach->nombre = $datos['nombre']; //yaneth
            $coach->apellido = $datos['apellido'];
            $coach->telefono = $datos['telefono'];
            $coach->correo = $datos['correo'];
            $coach->password = $datos['password'];
            $coach->id_materia = $datos['id_materia'];
            $coach->id_estado = 1;
            $coach->save();

            return response()->json(["status" => 200, "mensaje" => "Se ha registrado exitosamente"]);

        }else{
            return response()->json(["status" => 404, "mensaje" => "No se encontraron datos"]);
        }

        /**
         * updated_at = 15/10/2023 
         * created_at = 13/10/2023 
         */
    }

    //obtener un coach por su Id
    public function getCoachById($id){
        //
        //$coach = Coach::select('*')->where('id','=',$id)->get(); []
        $coach = Coach::find($id); //{}

        if(empty($coach)){
            return response()->json(["status" => 404, "detalle" => "No se encontraron resultados"]);
        }else{
            return response()->json($coach);
        }
    }

    #metodo para actualizar un coach
    public function update(Request $request, $id){
        $datos = array(
            "nombre" => $request->input('nombre'), 
            "apellido" => $request->input('apellido'),
            "telefono" => $request->input('telefono'),
            "correo" => $request->input('correo')
        );

        if(!empty($datos)){
            //select * from coach where id = 20
            $coach = Coach::find($id);
            $coach->nombre = $datos['nombre']; //yaneth
            $coach->apellido = $datos['apellido'];
            $coach->telefono = $datos['telefono'];
            $coach->correo = $datos['correo'];
            $coach->update();

            return response()->json(["status" => 200, "detalle" => "se ha actualizado correctamente"]);
        }else{
            return response()->json(["status" => 404, "detalle" => "No se actualizaron los campos"]);
        }
    }

    #metodo para cambiar el estado del coach
    public function deshabilitar($id){
        $coach = Coach::find($id);
        $coach->id_estado = 2;
        $coach->update();

        return response()->json(["status" => 200, "detalle" => "El coach esta inactivo"]);
    }


    #metodo para obtener todos los bootcamps
    public function obtenerBootcamps(){
        //select * from bootcamp => all()
        $bootcamps = Bootcamp::all();

        return response()->json($bootcamps);
    }

    #metodo para registrar bootcamps y su coach
    public function asignarBootcampsByCoach(Request $request, $id_coach){
        $bootcamps = $request->input('bootcamps'); //[]

        //iteramos el arreglo de bootcamps
        for($i = 0; $i < count($bootcamps); $i++){
            //guardamos la informacion a la tabla de bd
            $detalle = new Detalle_Bootcamp_Coach();
            $detalle->id_bootcamp = $bootcamps[$i];
            $detalle->id_coach = $id_coach;
            $detalle->save();
        }

        return response()->json(["status" => 200, "detalle" => "La peticion ha sido un exito"]);
    }


    #metodo para obtener los bootcamps por coach
    public function obtenerBootcampsByCoach(Request $request){
        /**
         * SELECT coach.nombre, bootcamp.bootcamp FROM coach INNER JOIN detalle_bootcamp_coach ON coach.id = detalle_bootcamp_coach.id_coach INNER JOIN bootcamp ON bootcamp.id = detalle_bootcamp_coach.id_bootcamp WHERE detalle_bootcamp_coach.id_coach = 1
         */

        $id = $request->input('id_coach');

        $detalle = Coach::join('detalle_bootcamp_coach','coach.id','=','detalle_bootcamp_coach.id_coach')->join('bootcamp','bootcamp.id','=','detalle_bootcamp_coach.id_bootcamp')->where('detalle_bootcamp_coach.id_coach','=',$id)->select('coach.nombre','bootcamp.bootcamp')->get();

        return response()->json($detalle);

    }



}
