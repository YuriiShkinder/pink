<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\PermissionsReporitory;
use App\Repositories\RolessReporitory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gate;

class PermissionsController extends AdminController
{
    protected $pre_rep;
    protected $rol_rep;

    public function __construct(PermissionsReporitory $pre_rep,RolessReporitory $rol_rep)
    {
        parent::__construct();
        if(Gate::denies('EDIT_USERS')){
            abort(403);
        }
        $this->pre_rep=$pre_rep;
        $this->rol_rep=$rol_rep;
        $this->template=env('THEME').'.admin.permissions';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title='Менеджер прав';
        $roles=$this->getRoles();
        $permission=$this->getPermission();
        $this->content=view(env('THEME').'.admin.permissions_content')->with(['roles'=>$roles,'priv'=>$permission])->render();
        return $this->renderOutput();
    }

    public function getPermission(){

        $per=$this->pre_rep->get();
        return $per;
    }

    public function getRoles(){
        $roles=$this->rol_rep->get();

        return $roles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = $this->pre_rep->changePermissions($request);

        if(is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }

        return back()->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
