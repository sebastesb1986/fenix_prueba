<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    // 1. Get list of users
    public function index()
    {
        try {

             // Politica donde solo un usuario admin puede ver todos los usuarios registrados
            $this->authorize('actions', User::class);
     
            // 1.2 Consultamos el usuario y su perfil
            $userFull = $this->userData()->get();

            return view('user.index', compact('userFull'));

        } catch (AuthorizationException $exception) {

            // Redirige al usuario a la página de inicio si no tiene permisos
            return redirect('/home');
        }

    }

    // 2. Perfil de usuario
    public function profile()
    {
        // Obtener usuario logueado
        $auth = auth()->user();

        // Consultamos el usuario y su perfil
        $query = $this->userData();

        $userFull = $query->findOrFail($auth->id);

        return view('user.user', compact('userFull'));
                
    }

    // 3. Mostrar usuario
    public function show($id)
    {
        // Obtener usuario logueado
        $auth = auth()->user();

        // Determinamos el perfil a consultar según el rol
        $userP = ($auth->admin == 1) ?  $id : $auth->id;

        // Obtener el perfil del usuario
        $userFull = $this->userData()->findOrFail($userP);

        return response()->json(['userFull' => $userFull]);
        
    }

    // 4. Registrar usuario
    public function store(UserRequest $request)
    {

        try {

            // Politica donde solo un usuario admin puede registrar usuarios
            $this->authorize('actions', User::class);

            // Datos de usuario que vienen desde la vista
            $data = [

                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password,

            ];

            // Registro del usuario
            $user = User::create($data);

            // Si el usuario ha sido registrado sin errores
            if($user)
            {
                // Datos del perfil que vienen desde la vista
                $profile = [

                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'gender' => $request->gender,

                ];

                // Registramos el perfil del usuario
                $user->profile()->create($profile);

                // Valida si el usuario y el perfil han sido registrados
                return response()->json([
                    'message' => 'Usuario registrado exitosamente!',
                ], 201);
            }
     
            return view('user.index');

        } catch (AuthorizationException $exception) {

            // Mensaje para el usuario si no tiene permisos
            return response()->json(['error'=>'No tienes permiso para agregar'], 403);
        }
        
    }

    // 5. Actualizar usuario
    public function update(UserRequest $request, $id)
    {
        // Obtener el usuario que ha iniciado sesión
        $auth = auth()->user();

        // Obtener el usuario a actualizarse
        $user = User::findOrFail($id);

        // Datos de usuario que vienen desde la vista
        $data = [

            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'admin' => ($auth->admin == 1) ? $request->admin : $user->admin,

        ];

        // Registro del usuario
        $update = $user->update($data);

        // Si el usuario ha sido registrado sin errores
        if($update)
        {
            // Datos del perfil que vienen desde la vista
            $profile = [

                'name' => $request->name,
                'lastname' => $request->lastname,
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => $request->gender,

            ];

            // Registramos el perfil del usuario
            $hh = $user->profile()->update($profile);

            // Valida si el usuario y el perfil han sido actualizados
            return response()->json([
                'message' => 'Usuario actualizado exitosamente!',
                'updatedData' => $user
            ], 201);
        }
  
    }

    // 6. Eliminar usuario
    public function delete($id)
    {
        // Obtener el usuario a ser eliminado
        $user = User::findOrFail($id);

        try {

            // Politica donde solo un usuario admin puede reliminar usuarios
            $this->authorize('actions', User::class);
            $delete = $user->delete();

        
            if($delete){

                return response()->json(['success'=>'Usuario eliminado exitosamente'], 200);

            }
        }
        catch (AuthorizationException $exception) {

            // Mensaje para el usuario si no tiene permisos
            return response()->json(['error'=>'No tienes permiso para eliminar'], 403);
        }

       
    }

    // 7. Función datos del usuario
    public function userData()
    {

        $query = User::with(['profile' => function($td){
        $td->select(['id', 'name', 'lastname', 'address', 'phone', 'gender', 'user_id']);
        }])
        ->select('id', 'username', 'email', 'admin');
    
        return $query;

    }

}
