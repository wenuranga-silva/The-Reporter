<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{

    //
    public function index()
    {

        return view('admin.permissions.index');
    }


    /// request for datatable
    public function getUserData()
    {

        $model = User::where('email_verified_at' ,'!=' ,null)
                    ->select('id' ,'name' ,'email' ,'status');

        return DataTables::eloquent($model)
            ->editColumn('name', function ($model) {

                return $model->name;
            })
            ->editColumn('status' ,function ($model) {

                $yes = $no = '';
                $model->status == 1 ? $yes = 'selected' : $no = 'selected';

                $status = '
                    <select class="form-control change_status" data-id="' . $model->id . '" data-mail="'. $model->email .'">
                        <option value="yes" ' . $yes . '>Yes</option>
                        <option value="no" ' . $no . '>No</option>
                    </select>
                ';

                return $status;
            })
            ->editColumn('role' ,function ($model) {

                $user = $writer = $admin = '';

                $u = $model; ////// model represent the user
                if ($u->hasRole('admin')) {

                    $admin = 'selected';
                } else if ($u->hasRole('writer')) {

                    $writer = 'selected';
                } else {

                    $user = 'selected';
                }

                $role = '
                    <select class="form-control change_role" data-id="' . $model->id . '" data-mail="'. $model->email .'">
                        <option value="user" ' . $user . '>User</option>
                        <option value="writer" ' . $writer . '>Writter</option>
                        <option value="admin" ' . $admin . '>Admin</option>
                    </select>
                ';

                return $role;
            })
            ->rawColumns(['status' ,'role'])
            ->toJson();
    }

    public function changeStatus(Request $request) {

        $request->validate([
            'id' => ['required' ,'integer'],
            'value' => ['required' ,'in:no,yes']
        ]);

        $user = User::findOrFail($request->id);

        $user->status = $request->value == 'yes' ? 1 :0;
        $user->update();

        return response(['status' => 'success', 'msg' => 'Status Updated !']);
    }

    public function changeRole(Request $request) {

        $request->validate([
            'id' => ['required' ,'integer'],
            'value' => ['required' ,'in:user,writer,admin']
        ]);

        $user = User::findOrFail($request->id);

        if ($user->hasAnyRole(['writer', 'admin'])) {

            $user->removeRole('writer');
            $user->removeRole('admin');
        }

        if ($request->value != 'user') {

            $user->assignRole($request->value);
        }

        return response(['status' => 'success', 'msg' => 'Role Updated !']);
    }

}
