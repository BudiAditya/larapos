<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;


class ExpenseController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('expenses-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $ezpos_expense_all = Expense::orderBy('id', 'desc')->get();
            return view('expense.index', compact('ezpos_expense_all', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $data['reference_no'] = 'er-' . date("Ymd") . '-'. date("his");
        Expense::create($data);
        return redirect('expenses')->with('message', 'Data inserted successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('expenses-edit')) {
            $ezpos_expense_data = Expense::find($id);
            $ezpos_expense_data->date = date('d-m-Y', strtotime($ezpos_expense_data->date));
            return $ezpos_expense_data;
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $ezpos_expense_data = Expense::find($data['expense_id']);
        $ezpos_expense_data->update($data);
        return redirect('expenses')->with('message', 'Data updated successfully');
    }

    public function destroy($id)
    {
        $ezpos_expense_data = Expense::find($id);
        $ezpos_expense_data->delete();
        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
    }
}