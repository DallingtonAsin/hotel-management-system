<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository
{
    protected $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function create($expenseData)
    {
        try {
            return $this->expense->create($expenseData);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function get($id)
    {
        try {
            return $this->expense->find($id);
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function update($id, $expenseData)
    {
        try {
            $expense = $this->expense->find($id);
            $expense->update($expenseData);
            return $expense;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {
            $expense = $this->expense->find($id);
            $expense->delete();
            return $expense;
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function count()
    {
        try {
            return $this->expense->where('is_deleted', false)->count();
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

    public function value()
    {
        try {
            return $this->expense->where('is_deleted', false)->sum('amount');
        } catch (\Exception $ex) {
            throw $ex;
        }
    }

   
}
