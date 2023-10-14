<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(){
        //select * from table => all()
        $coaches = Coach::all();
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
            "id_materia" => $request->input('id_materia'),
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
        $coach = Coach::select('*')->where('id','=',$id)->get();

        if(count($coach) == 0){
            return response()->json(["status" => 404, "detalle" => "No se encontraron resultados"]);
        }else{
            return response()->json(["status" => 200, "detalle" => $coach]);
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
}
