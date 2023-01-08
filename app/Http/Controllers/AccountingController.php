<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
{
    
    public function generateBalanceSheet(){
        try{
            $cash = number_format(50000);
            $accounts_receivable = number_format(15000);
            $inventory = number_format(90000);
            $prepaid_expenses = number_format(52000);
            $fixed_assets = number_format(78000);
            $total_assets = number_format(67000);
            $accounts_payable = number_format(1000);
            $accrued_expenses = number_format(14000);
            $total_liabilities = number_format(10000);
            $loans_payable = number_format(10000);
            $capital = number_format(8900);
            $retained_earnings = number_format(12000);
            $total_equity = number_format(3500);

            return view('pages.main.accounting.balance_sheet')->with(
                compact('cash', 'accounts_receivable', 'inventory', 'prepaid_expenses',
                 'fixed_assets', 'total_assets', 'accounts_payable', 'accrued_expenses',
                  'total_liabilities',  'loans_payable', 'capital', 'retained_earnings', 'total_equity')
            );
        }catch(\Exception $ex){
            throw $ex;
        }
    }

    public function generateCashFlowStatement(){
        try{
            return view('pages.main.accounting.cash_flow_statement');
        } catch(\Exception $ex){
            throw $ex;
        }
    }

    public function generateGeneralLedger(){
        try{
            return view('pages.main.accounting.general_ledger');
        } catch(\Exception $ex){
            throw $ex;
        }
    }
}
