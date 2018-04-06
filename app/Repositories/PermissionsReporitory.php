<?php
/**
 * Created by PhpStorm.
 * User: yurii
 * Date: 06.04.18
 * Time: 15:56
 */

namespace App\Repositories;

use App\Permission;
use Gate;
class PermissionsReporitory extends Repository
{
    protected  $rol_rep;
    public function __construct(Permission $permission,RolessReporitory $rol_rep)
    {
        $this->rol_rep=$rol_rep;
        $this->model=$permission;
    }

    public function changePermissions ($request) {

        if(Gate::denies('change', $this->model)) {
            abort(403);
        }

        $data = $request->except('_token');



        $roles = $this->rol_rep->get();



        foreach($roles as $value) {
            if(isset($data[$value->id])) {
                $value->savePermissions($data[$value->id]);
            }

            else {
                $value->savePermissions([]);
            }
        }

        return ['status' => 'Права обновлены'];
    }

}