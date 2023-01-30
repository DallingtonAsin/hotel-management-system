<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    protected $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }

    public function create($departmentData)
    {
        try {
            return $this->department->create($departmentData);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function get($id)
    {
        try {
            return $this->department->find($id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update($id, $departmentData)
    {
        try {
            $department = $this->department->find($id);
            $department->update($departmentData);
            return $department;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $department = $this->department->find($id);
            $department->delete();
            return $department;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function count()
    {
        try {
            return $this->department->where('is_deleted', false)->count();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function value()
    {
        try {
            return $this->department->where('is_deleted', false)->sum('amount');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function exists($code, $name)
    {
        try {
            return $this->department->where('code', $code)
            ->orWhere('name', $name)->exists();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function existsonUpdate($id, $code, $name)
    {
        try {
            return $this->department->where('id', '!=', $id)->where('code', $code)
            ->orWhere('name', $name)->exists();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

   
}