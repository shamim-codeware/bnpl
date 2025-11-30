<?php

namespace App\Http\Controllers;

use App\Models\GuaranterInfo;
use App\Models\HirePurchaseProduct;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use App\Models\CustomerProfession;
use Session;

class GuaranterInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $hire_purchase_id = Session::get('hire_purchase_id');
        $gurantors = GuaranterInfo::where('hire_purchase_id', $hire_purchase_id)->get();
        $title = "Customer Type";
        $description = "Some description for the page";


        $customers_professions = CustomerProfession::orderBy('id','DESC')->where('status', 1)->get();

        return view('installment.guaranter.guaranter',compact("gurantors","title","description","customers_professions"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        foreach ($request->id as $key => $id) {
            $guarantor = GuaranterInfo::where('id',$id)->first();
            if ($guarantor) {
                $guarantor->guarater_name = $request->guarater_name[$key];
                $guarantor->guarater_relation = $request->guarater_relation[$key];
                $guarantor->guarater_relation_name = $request->guarater_relation_name[$key];
                $guarantor->age = $request->age[$key];
                $guarantor->marital_status = $request->marital_status[$key];
                $guarantor->number_of_children = $request->number_of_children[$key];
                $guarantor->other_family_member = $request->other_family_member[$key];
                $guarantor->guarater_address_present = $request->guarater_address_present[$key];
                $guarantor->guarater_phone = $request->guarater_phone[$key];
                $guarantor->duration_of_staying = $request->duration_of_staying[$key];
                $guarantor->residense_status = $request->residense_status[$key];
                $guarantor->guarater_address_permanent = $request->guarater_address_permanent[$key];
                $guarantor->proffession_id = $request->proffession_id[$key];
                $guarantor->designation = $request->designation[$key];
                $guarantor->profession_phone = $request->profession_phone[$key];
                $guarantor->monthly_income = $request->monthly_income[$key];
                $guarantor->duration_current_profession = $request->duration_current_profession[$key];
                $guarantor->name_address_office = $request->name_address_office[$key];
                $guarantor->relation = $request->relation[$key];

                // Save the updated record
                $guarantor->save();
            }
        }

        return  redirect('all-purchase')->with('success', 'Success! Purchase Product ');

    }

    public function ViewGuarantor($hire_purchase_id){

        $guarantor = GuaranterInfo::with(['profession'])->where('hire_purchase_id',$hire_purchase_id)->get();
        $HirePurchaseProduct = HirePurchaseProduct::with(['product_category','brand','product'])->where('hire_purchase_id',$hire_purchase_id)->first();

        $HirePurchase = HirePurchase::with(['purchase_products',
            'purchase_products.product',
            'purchase_products.brand',
        ])->findOrFail($hire_purchase_id);

        return view('guarantorinfo',compact("guarantor","HirePurchaseProduct","HirePurchase"));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gurantors = GuaranterInfo::where('hire_purchase_id', $id)->get();
        $title = "Customer Type";
        $description = "Some description for the page";

        $customers_professions = CustomerProfession::orderBy('id', 'DESC')->where('status', 1)->get();

        return view('installment.guaranter.guaranter', compact("gurantors", "title", "description", "customers_professions"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuaranterInfo $guaranterInfo)
    {
        //z
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuaranterInfo $guaranterInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuaranterInfo $guaranterInfo)
    {
        //
    }
}
