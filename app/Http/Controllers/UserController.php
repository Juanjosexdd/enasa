<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Departamento;
use App\Http\Requests\UpdatePassRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Nacionalidad;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Caffeinated\Shinobi\Models\Role;
use Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('can:user.create')->only(['create', 'store']);
    //     $this->middleware('can:user.index')->only(['index']);
    //     $this->middleware('can:user.edit')->only(['edit', 'update']);
    //     $this->middleware('can:user.show')->only(['show']);
    //     $this->middleware('can:user.destroy')->only(['destroy']);
    //     $this->middleware('can:user.pdf')->only(['pdf']);
    // }
    // public function exportPdf(Request $request)
    // {
    //     // $users = User::all();
    //     $sql=trim($request->get('desde'));
    //     $sql2=trim($request->get('hasta'));


    //     $users= User::join('cargos','users.codcargo','=','cargos.id')
    //         ->join('nacionalidads','users.codnacionalidad','=','nacionalidads.id')
    //         ->join('departamentos','users.coddpto','=','departamentos.id')
    //         ->select('users.id','users.nombre','users.apellido','nacionalidads.abreviado as nacionalidad','users.cedula','cargos.nombre as cargo','departamentos.nombre as dpto','users.direccion','users.telefono',
    //         'users.email','users.usuario','users.created_at',
    //         'users.condicion')
    //         ->where('users.created_at','LIKE','%'.$sql.'%')
    //         ->orWhere('users.created_at','LIKE','%'.$sql2.'%')
    //         ->orderBy('users.id','asc')
    //         ->get();
    //     $pdf = PDF::loadView('pdf.users', compact('users'))->setPaper('a4', 'landscape');

    //     return $pdf->stream('listado-users.pdf');
    // }

    public function index(Request $request)
    {
        // if($request){

        //     $sql=trim($request->get('buscarTexto'));
        //     $users= User::join('cargos','users.codcargo','=','cargos.id')
        //     ->join('nacionalidads','users.codnacionalidad','=','nacionalidads.id')
        //     ->join('departamentos','users.coddpto','=','departamentos.id')
        //     ->select('users.id','users.nombre','users.apellido','nacionalidads.abreviado as nacionalidad','users.cedula','cargos.nombre as cargo','departamentos.nombre as dpto','users.direccion','users.telefono',
        //     'users.email','users.usuario','users.password',
        //     'users.condicion')
        //     ->where('users.nombre','LIKE','%'.$sql.'%')
        //     ->orderBy('users.id','desc')
        //     ->groupBy('users.id','users.nombre','users.apellido',
        //     'users.cedula','cargos.nombre','departamentos.nombre','users.direccion','users.telefono',
        //     'users.email','users.usuario','users.password',
        //     'users.condicion')
        //     ->paginate(10);
        //     $roles = Role::get();,["users"=>$users,"roles"=>$roles,"buscarTexto"=>$sql]

            return view('user.index');

            //return $usuarios;
        // }


    }
    public function show($id)
    {
        $user = User::find($id);
        return view('user.perfil.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::get();
        $nacionalidad = Nacionalidad::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
        $dpto = Departamento::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
        $cargo = Cargo::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
        return view('user.create', compact('roles','nacionalidad','dpto','cargo'),[
            'user' => new User
        ]);
    }


    public function store(UserRequest $request,User $user)
    {
        // $message = request()->validate([
        //     'nombre' => 'required|max:100',
        //     'apellido' => 'required|max:100',
        //     'codnacionalidad' => 'required',
        //     'coddpto' => 'required',
        //     'codcargo' => 'required',
        //     'cedula' => 'required|max:20|unique:users',
        //     'direccion' => 'required|max:70',
        //     'telefono' => 'required|max:20',
        //     'email' => 'required|max:50|unique:users|email',
        //     'usuario' => 'required|unique:users',
        //     'password' => 'required|max:100',
        //     'telefono' => 'required|max:100',
        //     'role' => 'required'
        // ]);

        $user = User::create($request->all());
        $user->roles()->sync($request->get('roles','user'));

        return Redirect::to("user");
    }

    // public function edit(User $user)
    // {
    //     $roles = Role::get();
    //     $nacionalidad = Nacionalidad::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
    //     $dpto = Departamento::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
    //     $cargo = Cargo::orderBy('nombre', 'DESC')->pluck('nombre', 'id');
    //     return view('user.edit', compact('user','roles','nacionalidad','dpto','cargo', $user->id));
    // }

    // public function update(UsersUpdateRequest $request,User $user)
    // {



    //     $user->update($request->all());

    //     $user->roles()->sync($request->get('roles'));

    //     $user->save();
    //     return redirect()->route('user.index')
    //         ->with('success', 'Usuario actualizado con éxito.');
    // }

    // public function updatePass(UpdatePassRequest $request,User $user)
    // {

    //     $user->update($request->all());
    //     $user->save();
    //     return redirect()->route('user.index')
    //         ->with('success', 'Usuario actualizado con éxito.');
    // }

    // public function destroy(Request $request)
    // {
    //     //
    //     $user= User::findOrFail($request->id_usuario);

    //      if($user->condicion=="1"){

    //             $user->condicion= '0';
    //             $user->save();
    //             return Redirect::to("user");

    //        }else{

    //             $user->condicion= '1';
    //             $user->save();
    //             return Redirect::to("user");

    //         }
    // }

}
